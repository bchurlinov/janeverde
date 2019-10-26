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
use App\AgriculturalLicense;
use App\CultivationLicense;
use App\IndustrialLicense;
use App\PictureID;

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
            $allUsers = User::where('role', '!=', 'admin')->get();
            //pending, verified, denied etc initialized to 0 initially 
            $pending = 0;
            $verified = 0;
            $noIDUploaded = 0;
            $denied = 0;
            $deleted = 0;
            $total = $allUsers->count();
            foreach ($allUsers as $singleUser) {
                switch ($singleUser->is_verified) {
                    case "-1":
                        $denied += 1;
                        break;
                    case "0":
                        $noIDUploaded += 1;
                        break;
                    case "1":
                        $verified += 1;
                        break;
                    case "2":
                        $pending += 1;
                        break;
                }
                if ($singleUser->is_deleted == 1) {
                    $deleted += 1;
                }
            }
            //create the return array for user's statistics
            $usersData = ["verified" => $verified, "pending" => $pending, "noIDUploaded" => $noIDUploaded, "denied" => $denied, "total" => $total, "deleted" => $deleted];

            //get all Products count from database
            $productsData = Product::count();

            return view('admin.dashboard')->with(["usersData" => $usersData, "productsData" => $productsData]);
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
        $verificationPendingUsers = User::where('is_verified', 2)->where('is_deleted', 0)->get();
        if ($redirect) {
            return redirect('/usersverification')->with('users', $verificationPendingUsers);
        }
        return view('admin.usersVerification')->with('users', $verificationPendingUsers);
    }

    public function getUsersForManagement($redirect = false)
    {
        $allUsers = User::where('role', '!=', 'admin')->get();
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
        $user = User::find($request->input('id'));
        //update the verification status
        $user->is_verified = 1;
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
        $user = User::find(explode("_", $request->input('id'))[0]);
        //remove the status, and unlink the uploaded id
        $user->is_verified = -1;
        $user->id_pic_uploaded = 0;
        $path = 'pictureID/' . $user->id_pic_name;
        //delete the image by calling unlink
        unlink(public_path($path));
        $user->id_pic_name = "";
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
            'name' => ["required", "regex:/^([a-zA-Z'-\w])((?![0-9]).)*$/m"],
            'lastname' => ["required", "regex:/^([a-zA-Z'-\w])((?![0-9]).)*$/m"]
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
            $token = self::getToken($request->email, $request->password);
            $user->auth_token = $token;
            $user->save();
            $response = ['success' => true, 'data' => ['id' => $user->id, 'auth_token' => $user->auth_token, 'name' => $user->name, 'email' => $user->email]];
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
            'password_confirm' => $request->password_confirm,
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
        if ($request->password != $request->password_confirm) {
            return response()->json(['success' => false, 'data' => 'Passwords do not match']);
        }
        //passwords are identical, add the user

        $user = new \App\User($payload);
        if ($user->save()) {
            $token = self::getToken($request->email, $request->password); // generate user token
            if (!is_string($token))  return response()->json(['success' => false, 'data' => 'Token generation failed'], 201);
            $user = \App\User::where('email', $request->email)->get()->first();
            $user->auth_token = $token; // update user token
            $user->save();
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
        $userId = (int) $request->get('user_id');
        $user = User::find($userId);
        $products = $user->products;
        $response = ['status' => 'success', 'products' => []];
        if (count($products) > 0) {
            foreach ($products as $product) {
                $response['products'][$product->id] = $product;
            }
        }
        return json_encode($response);
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

        $product = Product::where([['user_id', '=', $request->user_id], ['id', '=', $request->product_id]])->get();

        $response = ['status' => 'success', 'product' => []];

        if (count($product) > 0) {
            //convert the object to array if there is any product found
            $response['product'] = $product[0]->toArray();
        }
        return json_encode($response);
    }

    /**
     * add new agriculture licence
     */
    public function newAgLicence()
    {
        //header("Access-Control-Allow-Origin:*");
        request()->validate([
            'agriculture_business_name' => 'required',
            'agriculture_country' => 'required',
            'agriculture_licence' => 'required|numeric',
            'agriculture_bus_license' => 'required',
            'image' => 'required',
        ]);

        //get user id
        $loggedUserId = auth()->user()->id;

        //check for country details
        $country = Countries::where('name', '=', request()->get('agriculture_country'))->get()->first();
        if ($country == null) {
            echo json_encode(['status' => 'failed', 'reason' => 'invalid country']);
            return;
        }

        $img = request()->get('image');
        $name = $this->processImage($img, 'aglicence');

        $licence = new AgriculturalLicense();

        $licence->user_id = $loggedUserId;
        $licence->businessName = request()->get('agriculture_business_name');
        $licence->country_id = $country->id;
        $licence->agriculturalLicense = request()->get('agriculture_licence');
        $licence->bltid = request()->get('agriculture_bus_license');
        $licence->image = "aglicence/" . $name;
        $licence->verified = 2;

        //save licence
        $licence->save();

        return json_encode(['status' => 'success']);
    }

    public function newInLicence()
    {
        //header("Access-Control-Allow-Origin:*");
        request()->validate([
            'industrial_business_name' => 'required',
            'industrial_country' => 'required',
            'industrial_licence' => 'required|numeric',
            'industrial_bus_license' => 'required',
            'image' => 'required',
        ]);

        //get user id
        $loggedUserId = auth()->user()->id;

        //check for country details
        $country = Countries::where('name', '=', request()->get('industrial_country'))->get()->first();
        if ($country == null) {
            echo json_encode(['status' => 'failed', 'reason' => 'invalid country']);
            return;
        }

        $img = request()->get('image');
        $name = $this->processImage($img, 'inlicence');

        $licence = new IndustrialLicense();

        $licence->user_id = $loggedUserId;
        $licence->businessName = request()->get('industrial_business_name');
        $licence->country_id = $country->id;
        $licence->industrialLicense = request()->get('industrial_licence');
        $licence->bltid = request()->get('industrial_bus_license');
        $licence->image = "inlicence/" . $name;
        $licence->verified = 2;

        //save licence
        $licence->save();

        return json_encode(['status' => 'success']);
    }

    public function newCuLicence()
    {
        //header("Access-Control-Allow-Origin:*");
        request()->validate([
            'cultivation_business_name' => 'required',
            'cultivation_country' => 'required',
            'cultivation_licence' => 'required|numeric',
            'cultivation_bus_license' => 'required',
            'image' => 'required',
        ]);

        //get user id
        $loggedUserId = auth()->user()->id;

        //check for country details
        $country = Countries::where('name', '=', request()->get('cultivation_country'))->get()->first();
        if ($country == null) {
            echo json_encode(['status' => 'failed', 'reason' => 'invalid country']);
            return;
        }

        $img = request()->get('image');
        $name = $this->processImage($img, 'culicence');

        $licence = new CultivationLicense();

        $licence->user_id = $loggedUserId;
        $licence->businessName = request()->get('cultivation_business_name');
        $licence->country_id = $country->id;
        $licence->cultivationLicense = request()->get('cultivation_licence');
        $licence->bltid = request()->get('cultivation_bus_license');
        $licence->image = "culicence/" . $name;
        $licence->verified = 2;

        //save licence
        $licence->save();

        return json_encode(['status' => 'success']);
    }

    public function newPictureId(Request $request)
    {
        $request->validate([
            'identification_name' => 'required',
            'identification_lastname' => 'required',
            'identification_country' => 'required',
            'identification_number' => 'required',
            'identification_street_address' => 'required',
            'identification_image' => 'required'
        ]);
        //get user id
        $loggedUserId = auth()->user()->id;

        //check for country details
        $country = Countries::where('name', '=', request()->get('identification_country'))->get()->first();
        if ($country == null) {
            echo json_encode(['status' => 'failed', 'reason' => 'invalid country']);
            return;
        }

        $img = request()->get('identification_image');
        $name = $this->processImage($img, 'pictureID');

        $user = new PictureID();
        $user->user_id = $loggedUserId;
        $user->cardname = $request->get('identification_name');
        $user->cardlastname = $request->get('identification_lastname');
        $user->country_id = $country->id;
        $user->cardnumber = $request->get('identification_number');
        $user->cardstreet = $request->get('identification_street_address');
        $user->image = 'pictureID/' . $name;
        $user->verified = 2;

        //save the new picture id
        $user->save();

        return json_encode(['status' => 'success']);
    }

    public function editUserPictureId(Request $request)
    {
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
                return json_encode(["status" => "failed", "reason", "Your current password does not match with the password you provided"]);
            }
            if (strcmp($request->get('current_password'), $request->get('new_password')) == 0) {
                //Current password and new password are same
                return json_encode(["status" => "failed", "reason" => "New Password cannot be same as your current password. Please choose a different password"]);
            }
            if (strcmp($request->get('new_password'), $request->get('password_confirmation')) != 0) {
                //new password and password confirmation dont match
                return json_encode(['status' => 'failed', 'reason' => 'New password and confirmation passwords dont match']);
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
            unlink(public_path() . "/users/" . $user->id_pic_name);
        }
        
        $img = request()->get('image');
        $name = count($img) > 0 ? $this->processImage($img, 'users') : $user->id_pic_name;

        $user->phone_number = $request->get('phone_number') == null ? $user->phone_number : $request->get('phone_number');
        $user->id_pic_name = $name;
        
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
}
