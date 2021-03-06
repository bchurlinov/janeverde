<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Hash;
use JWTAuth;
use JWTAuthException;
use App\Product;
use App\Countries;
use App\IndustrialLicense;
use App\BusinessLicense;
use App\PictureID;
use App\Subcategories;
use Carbon\Carbon;
use App\Favorite;
use App\SupportingDocuments;
use Illuminate\Support\Str;
use App\Drafts;
use App\UserEmails;

class UserController extends Controller
{
    /**
     * get logged user details
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $user = User::find(auth()->user()->id);
        if ($user->role == "admin") {
            //get all users, excluding the administrator from the counts
            $allUsers = User::with('pictureID')->where('role', '=', NULL)->get();
            //pending, verified, denied etc initialized to 0 initially 
            $pending = 0;
            $verified = 0;
            $noIDUploaded = 0;
            $denied = 0;
            $deleted = 0;
            $total = $allUsers->count();
            if($total > 0){
                foreach ($allUsers as $singleUser) {
                    $picid = $singleUser->pictureID;
                    if($picid == null){
                        $noIDUploaded += 1;
                        continue;
                    }
                    if($picid->verified == -1){
                        $denied += 1;
                        continue;
                    }
                    if($picid->verified == 1){
                        $verified += 1;
                        continue;
                    }
                    if($picid->verified == 2){
                        $pending += 1;
                        continue;
                    }
                    if ($singleUser->is_deleted == 1) {
                        $deleted += 1;
                        continue;
                    }
                }
            }
            //create the return array for user's statistics
            $usersData = ["verified" => $verified, "pending" => $pending, "noIDUploaded" => $noIDUploaded, "denied" => $denied, "total" => $total, "deleted" => $deleted];

            //get all Products count from database
            $productsData = Product::count();

            return view('admin.dashboard')->with(["usersData" => $usersData, "productsData" => $productsData]);
        }
        else{
            return redirect()->back();
        }
        return view('auth.dashboard')->with('user', $user);
    }

    /**
     * picture id upload
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function uploadID()
    {
        request()->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $imageName = time() . '.' . request()->image->getClientOriginalExtension();

        //get user details so we can update image name and that he has uploaded an image
        $loggedUser = User::find(auth()->user()->id);
        $loggedUser->id_pic_name = $imageName;
        $loggedUser->id_pic_uploaded = 1;

        /*
         * update also verification status. we need to keep track whether the user hasn't uploaded, denied or whatever reason. codes:
         * -1: user is denied of the upload, and has to re-upload picture id
         * 0 : user is created, hasn't uploaded picture id
         * 1 : user is created, uploaded id and verified(approved by admin)
         * 2 : user is created, uploaded id, awaiting verification
         */
        $loggedUser->is_verified = 2;

        //save the uploaded details
        $loggedUser->save();

        request()->image->move(public_path('pictureID'), $imageName);
        return back()->with('success', 'You have successfully upload image.')->with('image', $imageName);
    }

    /**
     * get all users that are queued up for verification and are not deleted
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getUsersForVerification($redirect = false)
    {
        $verificationPendingUsers = PictureID::with('user')->where('verified', 2)->get();
        if ($redirect) {
            return redirect('/usersverification')->with('users', $verificationPendingUsers);
        }
        return view('admin.usersVerification')->with('users', $verificationPendingUsers);
    }

    public function getUsersForManagement($redirect = false)
    {
        $allUsers = User::with('pictureID')->where('role', '=', NULL)->get();
        $deleted = $notDeleted = [];
        foreach ($allUsers as $users) {
            $users->is_deleted == 0 ? $notDeleted[] = $users : $deleted[] = $users;
        }
        if ($redirect) {
            return redirect('/usersmanagement')->with(['users' => $notDeleted, 'deleted' => $deleted]);
        }
        return view('admin.usersManagement')->with(['users' => $notDeleted, 'deleted' => $deleted]);
    }

    /**
     * approve uploaded picture id
     * @param int $id the user id to approve the uploaded picture
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function approve(Request $request)
    {   
        //get the user by id
        $user = PictureID::where('user_id', '=', $request->input('id'))->get()->first();
        //update the verification status
        $user->verified = 1;
        //save the status
        $user->save();
        return $this->getUsersForVerification(true);
    }

    /**
     * Decline user uploaded picture ID
     * @param int $id the user id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function decline(Request $request)
    {
        //get the user by id
        $user = PictureID::where('user_id', '=', explode("_", $request->input('id'))[0])->get()->first();
        //remove the status, and unlink the uploaded id
        $user->verified = -1;
        $path = $user->image;
        $user->image = NULL;
        
        //delete the image by calling unlink
        unlink(public_path()."/".$path);
        $user->save();
        return $this->getUsersForVerification(true);
    }

    /**
     * soft delete the user
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function delete(Request $request)
    {
        $user = User::find($request->input('id'));
        //set is_deleted to 1
        $user->is_deleted = 1;
        $user->save();
        return $this->getUsersForManagement(true);
    }

    /**
     * restore the deleted user
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function restore(Request $request)
    {
        $user = User::find(explode('_', $request->input('id'))[0]);
        //set is_deleted to 0
        $user->is_deleted = 0;
        $user->save();
        return $this->getUsersForManagement(true);
    }

    /**
     * change user password
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changePassword(Request $request)
    {
        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error", "Your current password does not match with the password you provided. Please try again.");
        }
        if (strcmp($request->get('current-password'), $request->get('new-password')) == 0) {
            //Current password and new password are same
            return redirect()->back()->with("error", "New Password cannot be same as your current password. Please choose a different password.");
        }
        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:8|confirmed',
        ]);
        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();
        return redirect()->back()->with("success", "Password changed successfully!");
    }

    public function settings(Request $request)
    {
        $validate = $request->validate([
            'name' => "required",
            'lastname' => "required"
        ]);
        $user = User::find(Auth::user()->id);
        $user->name = $request->get('name');
        $user->lastname = $request->get('lastname');
        $user->save();
        return redirect()->back()->with('success', 'Your data has been updated successfully');
    }

    private function getToken($email, $password)
    {
        $token = null;
        //$credentials = $request->only('email', 'password');
        try {
            if (!$token = JWTAuth::attempt(['email' => $email, 'password' => $password])) {
                return response()->json([
                    'response' => 'error',
                    'message' => 'Password or email is invalid',
                    'token' => $token
                ]);
            }
        } catch (JWTAuthException $e) {
            return response()->json([
                'response' => 'error',
                'message' => 'Token creation failed',
            ]);
        }
        return $token;
    }

    /**
     * Log user through api using jwt
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $user = \App\User::where('email', $request->email)->get()->first();
        if ($user && \Hash::check($request->password, $user->password)) {
            if($user->email_verified_at == null){
                $response = ['success' => false, 'data' => 'Your email is not verified. Please check your email for verification'];
            }
            else{
                $token = self::getToken($request->email, $request->password);
                $user->auth_token = $token;
                $user->save();
                $response = ['success' => true, 'data' => ['id' => $user->id, 'auth_token' => $user->auth_token, 'name' => $user->name, 'email' => $user->email]];
            }
            
        } else {
            $response = ['success' => false, 'data' => "Username and/or password don't match our records"];
        }
        return response()->json($response, 201);
    }

    /**
     * new user sign up
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $payload = [
            'password' => \Hash::make($request->password),
            'password_confirmation' => $request->password_confirm,
            'email' => $request->email,
            'name' => $request->name,
            'lastname' => $request->lastname,
            'auth_token' => ''
        ];

        //check for email and then for passwords
        $user = User::where('email', '=', $request->email)->get();
        if (count($user) > 0) {
            return response()->json(['success' => false, 'data' => 'The username exists, try choose another']);
        }
        //email is unique, proceed with password
        if ($request->password != $request->password_confirmation) {
            return response()->json(['success' => false, 'data' => 'Passwords do not match']);
        }
        //passwords are identical, add the user

        $user = new \App\User($payload);
        if ($user->save()) {
            $token = self::getToken($request->email, $request->password); // generate user token
            if (!is_string($token))  return response()->json(['success' => false, 'data' => 'Token generation failed'], 201);
            $user = \App\User::where('email', $request->email)->get()->first();
            $email = $user->email;
            $user->auth_token = $token; // update user token
            $user->save();
            //$user->sendEmailVerificationNotification();
            //send email

            $transport = (new \Swift_SmtpTransport('a2plcpnl0781.prod.iad2.secureserver.net', 25))
                ->setUsername('contact@janeverde.com')->setPassword('cxewke3)eT-;');
            $mailer = new \Swift_Mailer($transport);
            $body  = "Click <a href='".config('variables.phpurl')."/verifyemail?e=".$email."'>here</a> ";
            $body .= "to verify your email address.";
            $message = (new \Swift_Message("Email verification"))->setFrom(['contact@janeverde.com' => 'JaneVerde email verification'])
                ->setTo([$email])->setBody($body);
            $message->setContentType("text/html");
            $mailer->send($message);

            //add email validation here
            $response = ['success' => true, 'data' => ['name' => $user->name, 'id' => $user->id, 'email' => $request->email, 'auth_token' => $token]];
        } else {
            $response = ['success' => false, 'data' => 'Couldnt register user, please try again later'];
        }
        return response()->json($response, 201);
    }

    /**
     * get all products by user id
     * @param Request $request
     * @return string $response
     */
    public function getProductsAPI(Request $request)
    {
        $validate = $request->validate([
            'user_id' => 'required|numeric'
        ]);
        
        $userId = (int)$request->get('user_id');
        
        $user = User::find($userId);
        $products = $user->products;
        //$drafts = $user->drafts;
        $response = ['status' => 'success', 'products' => 
            [
                "active" => [],
                "expired" => [],
                "favorite" => []/*,
                "drafts" => []*/
            ]
        ];

        if ($products->count() > 0) {
            foreach ($products as $product) {
                if($product->is_deleted == "0"){
                    $product->id = (int)$product->id;
                    $product->user_id = (int)$product->user_id;
                    $product->price = (int)$product->price;
                    $product->country_id = (int)$product->country_id;
                    $product->is_deleted = (int)$product->is_deleted;
                    $product->type = ucfirst($product->type);
                    $product->category_id = (int)$product->category_id;
                    $product->verified = (int)$product->verified;
                    $product->subcategory_id = $this->getSubCategory($product->subcategory_id)[0]['name'];
                    $created = $product->created_at;
                    $today = Carbon::createFromFormat('Y-m-d h:i:s', date('Y-m-d h:i:s'));
                    $days = $today->diff($created)->days;
                    $days > 90 ? $response['products']['expired'][] = $product : $response['products']['active'][] = $product;
                }
            }
        }

        /*if ($drafts->count() > 0) {
            foreach ($drafts as $product) {
                if($product->is_deleted == "0"){
                    $product->id = (int)$product->id;
                    $product->user_id = (int)$product->user_id;
                    $product->price = (int)$product->price;
                    $product->country_id = (int)$product->country_id;
                    $product->category_id = (int)$product->category_id;
                    $response['drafts'][] = $product;
                }
            }
        }*/

        //get favorites, and add them to the favorite array
        $fav = Favorite::where('user_id', '=', (int)$userId)->get();
        if($fav->count() > 0){
            $favorite = array_filter(explode(',', $fav[0]->product_id));
            //find the products now
            $prd = Product::whereIn("id", $favorite)->get();
            if($prd->count() > 0){
                foreach($prd as $p){
                    if($p->is_deleted == "0"){
                        $p->id = (int)$p->id;
                        $p->user_id = (int)$p->user_id;
                        $p->price = (int)$p->price;
                        $p->country_id = (int)$p->country_id;
                        $p->is_deleted = (int)$p->is_deleted;
                        $p->type = ucfirst($p->type);
                        $p->category_id = (int)$p->category_id;
                        $p->verified = (int)$p->verified;
                        $p->subcategory_id = $this->getSubCategory($p->subcategory_id)[0]['name'];
                        $response['products']['favorite'][] = $p;
                    }
                    
                }
            }
        }

        return json_encode($response);
    }

    public function getSubCategory($catId){
        return Subcategories::where('number', '=', $catId)->get();
    }

    /**
     * Get product details by user id and product id
     * @param Request $request
     * @return json $response json encoded string
     */
    public function getProductDetailsByUserIDAPI(Request $request)
    {
        $validate = $request->validate([
            'user_id' => 'required|numeric',
            'product_id' => 'required|numeric'
        ]);

        $product = Product::where([['user_id', '=', $request->user_id], ['id', '=', $request->product_id], ['is_deleted', '=', '0']])->get();

        $response = ['status' => 'success', 'product' => []];

        if (count($product) > 0) {
            $images = [];
            //convert the object to array if there is any product found
            $product = $product[0]->toArray();
            foreach($product as $key => $value){
                if(substr($key, 0, 3) === "img"){
                    if($value != null){
                        $images[] = $value;
                    }
                    unset($product[$key]);
                }
            }
            $product['type'] = ucfirst($product['type']);
            $product['subcategory_id'] = $this->getSubCategory($product['subcategory_id'])[0]['name'];
            $product['images'] = $images;
            $response['product'] = $product;
            
        }
        return json_encode($response);
    }

    public function newInLicence()
    {
        request()->validate([
            'industrial_license_number' => 'required',
            'industrial_expiration_date' => 'required',
            'industrial_image' => 'required',
        ]);

        //get user id
        $loggedUserId = auth()->user()->id;

        // if(count(request()->get(image)) == 0){
        //     return json_encode(['status' => 'failed', 'reason' => 'No images sent']);
        // }

        $img = request()->get('industrial_image');
        $name = $this->processImageLicense($img, 0, 'inlicence');
        $img2 = $img3 = null;

        if(!empty($img[1])){ $img2 = $this->processImageLicense($img, 1, 'inlicence'); }
        if(!empty($img[2])){ $img3 = $this->processImageLicense($img, 2, 'inlicence'); }

        $b = IndustrialLicense::where('user_id', '=', $loggedUserId)->get();
        $licence = $b->count() > 0 ? IndustrialLicense::find($b[0]['id']) : new IndustrialLicense();

        $licence->user_id = $loggedUserId;
        $licence->licensenumber = request()->get('industrial_license_number');
        $licence->expiration_date = request()->get('industrial_expiration_date');
        $licence->img1 = "inlicence/" . $name;
        $licence->img2 = $img2 == null ? null : "inlicence/".$img2;
        $licence->img3 = $img3 == null ? null : "inlicence/".$img3;
        $licence->verified = 2;

        //save licence
        $licence->save();

        return json_encode(['status' => 'success']);
    }

    public function newBuLicence()
    {
        request()->validate([
            'business_license_number' => 'required',
            'business_expiration_date' => 'required',
            'business_image' => 'required',
        ]);

        //get user id
        $loggedUserId = auth()->user()->id;

        // if(count(request()->get(image)) == 0){
        //     return json_encode(['status' => 'failed', 'reason' => 'No images sent']);
        // }

        $img = request()->get('business_image');
        $name = $this->processImageLicense($img, 0, 'bulicence');
        $img2 = $img3 = null;

        if(!empty($img[1])){ $img2 = $this->processImageLicense($img, 1, 'bulicence'); }
        if(!empty($img[2])){ $img3 = $this->processImageLicense($img, 2, 'bulicence'); }

        $b = BusinessLicense::where('user_id', '=', $loggedUserId)->get();
        $licence = $b->count() > 0 ? BusinessLicense::find($b[0]['id']) : new BusinessLicense();

        $licence->user_id = $loggedUserId;
        $licence->licensenumber = request()->get('business_license_number');
        $licence->expiration_date = request()->get('business_expiration_date');
        $licence->img1 = "bulicence/" . $name;
        $licence->img2 = $img2 == null ? null : "bulicence/".$img2;
        $licence->img3 = $img3 == null ? null : "bulicence/".$img3;
        $licence->verified = 2;

        //save licence
        $licence->save();

        return json_encode(['status' => 'success']);
    }

    public function newPictureId(Request $request)
    {
        $request->validate([
            'identification_expiration_date' => 'required',
            'identification_image' => 'required'
        ]);
        //get user id
        $loggedUserId = auth()->user()->id;

        $img = request()->get('identification_image');
        $name = $this->processImage($img, 'pictureID');

        $b = PictureID::where('user_id', '=', $loggedUserId)->get();
        $user = $b->count() > 0 ? PictureID::find($b[0]['id']) : new PictureID();
        $user->user_id = $loggedUserId;
        $user->expiration_date = $request->get('identification_expiration_date');

        $user->image = 'pictureID/' . $name;
        $user->verified = 2;

        //save the new picture id
        $user->save();

        return json_encode(['status' => 'success']);
    }

    public function editUserPictureId(Request $request)
    {
        //i tuka kje treba samo dve polinja da ima
        $request->validate([
            'identification_name' => 'nullable', //name
            'identification_lastname' => 'nullable', //lastname
            'identification_country' => 'nullable', //to be added
            'image' => 'nullable', //id_pic_name
            'current_password' => 'nullable', //password
            'new_password' => 'nullable',
            'password_confirmation' => 'nullable',
            'phone_number' => 'nullable' //to be added
        ]);
        //get user id
        $loggedUserId = auth()->user()->id;
        $user = User::find($loggedUserId);

        if ($user == null) {
            return json_encode(['status' => 'failed', 'reason' => 'The user doesnt exist']);
        }

        if ($request->get("identification_country") != "") {
            //check for country details
            $country = Countries::where('name', '=', request()->get('identification_country'))->get()->first();
            if ($country == null) {
                echo json_encode(['status' => 'failed', 'reason' => 'invalid country']);
                return;
            }
        }

        if ($request->get('current_password') != "") {
            if (!(Hash::check($request->get('current_password'), $user->password))) {
                // The passwords is wrong
                return json_encode(["status" => "failed", "reason" => "Your current password does not match with the password you provided"]);
            }
            if (strcmp($request->get('current_password'), $request->get('new_password')) == 0) {
                //Current password and new password are same
                return json_encode(["status" => "failed", "reason" => "New Password cannot be same as your current password. Please choose a different password"]);
            }
            if (strcmp($request->get('new_password'), $request->get('password_confirmation')) != 0) {
                //new password and password confirmation dont match
                return json_encode(["status" => "failed", "reason" => "New password and confirmation passwords don't match"]);
            }
            //all checks are good, update user password
            $user->password = bcrypt($request->get('new_password'));
        }

        //update user name and last name
        $user->name = $request->get('identification_name') == null ? $user->name : $request->get('identification_name');
        $user->lastname = $request->get('identification_lastname') == null ? $user->lastname : $request->get('identification_lastname');
        $user->country = empty($country) ? $user->country : $country->name;

        //unlink the old image
        if ($user->id_pic_name != null && count($request->get('image')) > 0) {
            //unlink(public_path() . "/users/" . $user->id_pic_name);
        }
        
        //$img = request()->get('image');
        //$name = count($img) > 0 ? $this->processImage($img, 'users') : $user->id_pic_name;

        $user->phone_number = $request->get('phone_number') == null ? $user->phone_number : $request->get('phone_number');
        //$user->id_pic_name = $name;
        
        $user->save();
        return json_encode(["status" => "success", "reason" => "User data updated successfully"]);
    }

    public function processImage($img, $type)
    {
        $img = $img[0];
        $img = explode(';', $img);
        $name = str_replace("name=", "", $img[1]);
        $name = explode(".", $name);
        $extension = $name[count($name) - 1];
        unset($name[count($name) - 1]);
        $name = md5(implode(".", $name)) . time() . "." . $extension;
        $content = str_replace("base64,", "", $img[2]);
        \File::put(public_path() . '/' . $type . '/' . $name, base64_decode($content));
        return $name;
    }

    public function processImageLicense($img, $index, $type){
        $img = $img[$index];
        $img = explode(';', $img);
        $name = str_replace("name=", "", $img[1]);
        $name = explode(".", $name);
        $extension = $name[count($name) - 1];
        unset($name[count($name) - 1]);
        $name = md5(implode(".", $name)).time().".".$extension;
        $content =str_replace("base64,", "", $img[2]);
        \File::put(public_path(). '/' . $type . '/' . $name, base64_decode($content));
        return $name;
    }

    public static function postsCount($uid){
        $usr = User::find($uid);
        $counts = [
            'active' => 0,
            'expired' => 0,
            'favorite' => 0
        ];
        if($usr == null){
            return $counts;
        }

        $active = 0;
        $expired = 0;
        $favorite = 0;

        //get user's products so we can count
        $products = Product::where('user_id', '=', $uid)->get();
        if($products->count() > 0){
            foreach($products as $product){
                $created = $product->created_at;
                $today = Carbon::createFromFormat('Y-m-d h:i:s', date('Y-m-d h:i:s'));
                $days = $today->diff($created)->days;
                $days > 90 ? $expired += 1 : $active += 1;
            }
        }

        //get favorited, so we can count
        $fav = Favorite::where('user_id', '=', $uid)->get();
        if($fav->count() > 0){
            $favorite = count(array_filter(explode(',', $fav[0]->product_id)));
        }

        //set the corresponding numbers
        $counts['active']   = $active;
        $counts['expired']  = $expired;
        $counts['favorite'] = $favorite;

        return $counts;
    }

    public function supportingDocuments(Request $request){
        $request->validate([
            'additional_documents' => 'required'
        ]);

        $img = $request->get('additional_documents');
        $name = $this->processImageLicense($img, 0, 'supportingdocuments');
        $img2 = $img3 = $img4 = $img5 = null;

        if(!empty($img[1])){ $img2 = $this->processImageLicense($img, 1, 'supportingdocuments'); }
        if(!empty($img[2])){ $img3 = $this->processImageLicense($img, 2, 'supportingdocuments'); }
        if(!empty($img[3])){ $img4 = $this->processImageLicense($img, 3, 'supportingdocuments'); }
        if(!empty($img[4])){ $img5 = $this->processImageLicense($img, 4, 'supportingdocuments'); }

        $loggedUserId = auth()->user()->id;

        $b = SupportingDocuments::where('user_id', '=', $loggedUserId)->get();
        $sd = $b->count() > 0 ? SupportingDocuments::find($b[0]['id']) : new SupportingDocuments();

        $sd->user_id = $loggedUserId;
        $sd->img1 = "supportingdocuments/".$name;
        $sd->img2 = $img2 == null ? null : "supportingdocuments/".$img2;
        $sd->img3 = $img3 == null ? null : "supportingdocuments/".$img3;
        $sd->img4 = $img4 == null ? null : "supportingdocuments/".$img4;
        $sd->img5 = $img5 == null ? null : "supportingdocuments/".$img5;
        $sd->verified = 2;

        $sd->save();
        return json_encode(['status' => 'success']);
    }

    public function vf1(Request $request){
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'state' => 'required',
            'company_name' => 'required',
            'entity_type' => 'required',
            'phone' => 'required'
        ]);

        $loggedUserId = auth()->user()->id;
        $user = User::find($loggedUserId);

        $allowed_entity_types = ["farmer", "processor", "manufacturer", "broker_wholesaler", "consultant",
        "retail", "equipment_manufacturer", "other"];

        $types = $request->get('entity_type');
        $typesok = true;
        foreach($types as $type){
            if(!in_array($type, $allowed_entity_types)){
                $typesok = false;
            }
        }
        if(!$typesok) { return json_encode(['status' => 'failed', 'reason' => 'One or more Type of entity is incorrect']); }

        //check for country details
        $country = Countries::where('name', '=', $request->get('state'))->get()->first();
        if ($country == null) {
            echo json_encode(['status' => 'failed', 'reason' => 'invalid country']);
            return;
        }

        $user->name = $request->get('first_name');
        $user->lastname = $request->get('last_name');
        $user->country = $request->get('state');
        $user->company = $request->get('company_name');
        $user->entity_type = implode(',', $request->get('entity_type'));
        $user->phone_number = $request->get('phone');
        $user->verification_step_1 = 1;

        $user->save();

        return json_encode(['status' => 'success']);
    }

    public function forgotPasswordReset(Request $request){
        $request->validate([
            'email' => 'required|email'
        ]);
        $email = $request->get('email');

        $user = User::all()->where('email', '=', $email)->first();
        if($user != null){
            //generate new password
            $newpass = Str::random(12);

            //change the password in database
            $user->password = bcrypt($newpass);
            $user->save();

            $transport = (new \Swift_SmtpTransport('a2plcpnl0781.prod.iad2.secureserver.net', 25))
                ->setUsername('contact@janeverde.com')->setPassword('cxewke3)eT-;');
            $mailer = new \Swift_Mailer($transport);

            $body  = "Your new password is: ".$newpass;
            $body .= "<br /> Visit <a href='".config('variables.reacturl')."/signin'> your profile</a> to change the password in user settings.";

            $message = (new \Swift_Message("Password reset"))->setFrom(['contact@janeverde.com' => 'JaneVerde password reset'])
                ->setTo([$email])->setBody($body);

            $message->setContentType("text/html");
            $mailer->send($message);
        }
        return json_encode(['status' => 'success', 'reason' => 'Please check your email']);
    }

    public function sendemailfriend(Request $request){
        parse_str($request->get('fdata'), $output);

        $transport = (new \Swift_SmtpTransport('a2plcpnl0781.prod.iad2.secureserver.net', 25))
            ->setUsername('contact@janeverde.com')->setPassword('cxewke3)eT-;');
        $mailer = new \Swift_Mailer($transport);
        $body  = "Hey, your friend ".$output['name']." sent you this <a href='".config('variables.phpurl')."/view/".$output['product_url']."'>post</a> ";
        $body .= " from ".config('variables.phpurl').". Check it out!";
        $message = (new \Swift_Message("Check this post!"))->setFrom(['contact@janeverde.com' => 'JaneVERDE'])
            ->setTo([$output['friends_name']])->setBody($body);
        $message->setContentType("text/html");
        $mailer->send($message);

        echo "1";
    }
    
    public function mmm(){
        $a = new xmlapi("127.0.0.1");
    }
}
