<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Hash;
use JWTAuth;
use JWTAuthException;
use App\Product;

class UserController extends Controller
{
    /**
     * get logged user details
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        $user = User::find(auth()->user()->id);
        if($user->role == "admin"){
            //get all users, excluding the administrator from the counts
            $allUsers = User::where('role', '!=', 'admin')->get();
            //pending, verified, denied etc initialized to 0 initially 
            $pending = 0;
            $verified = 0;
            $noIDUploaded = 0;
            $denied = 0;
            $deleted = 0;
            $total = $allUsers->count();
            foreach($allUsers as $singleUser){
                switch($singleUser->is_verified){
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
                if($singleUser->is_deleted == 1){ $deleted += 1; }
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
    public function uploadID(){
        request()->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $imageName = time().'.'.request()->image->getClientOriginalExtension();

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
        return back()->with('success','You have successfully upload image.')->with('image',$imageName);
    }

    /**
     * get all users's purchased products
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function buyerPurchasedProducts(){
        $user = User::find(auth()->user()->id);
        return view('auth.buyerPurchased')->with('userProducts', $user->products);
    }

    /**
     * get all users that are queued up for verification and are not deleted
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getUsersForVerification($redirect = false){
        $verificationPendingUsers = User::where('is_verified', 2)->where('is_deleted', 0)->get();
        if($redirect){
            return redirect('/usersverification')->with('users', $verificationPendingUsers);
        }
        return view('admin.usersVerification')->with('users', $verificationPendingUsers);
    }

    public function getUsersForManagement($redirect = false){
        $allUsers = User::where('role', '!=', 'admin')->get();
        $deleted = $notDeleted = [];
        foreach($allUsers as $users){
            $users->is_deleted == 0 ? $notDeleted[] = $users : $deleted[] = $users;
        }
        if($redirect){
            return redirect('/usersmanagement')->with(['users' => $notDeleted, 'deleted' => $deleted]);
        }
        return view('admin.usersManagement')->with(['users' => $notDeleted, 'deleted' => $deleted]);
    }

    /**
     * approve uploaded picture id
     * @param int $id the user id to approve the uploaded picture
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function approve(Request $request){
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
    public function decline(Request $request){
        //get the user by id
        $user = User::find(explode("_", $request->input('id'))[0]);
        //remove the status, and unlink the uploaded id
        $user->is_verified = -1;
        $user->id_pic_uploaded = 0;
        $path = 'pictureID/'.$user->id_pic_name;
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
    public function delete(Request $request){
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
    public function restore(Request $request){
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
    public function changePassword(Request $request){
        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error","Your current password does not match with the password you provided. Please try again.");
        }
        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
            //Current password and new password are same
            return redirect()->back()->with("error","New Password cannot be same as your current password. Please choose a different password.");
        }
        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:8|confirmed',
        ]);
        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();
        return redirect()->back()->with("success","Password changed successfully!");
    }

    public function settings(Request $request){
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

    private function getToken($email, $password){
        $token = null;
        //$credentials = $request->only('email', 'password');
        try {
            if (!$token = JWTAuth::attempt( ['email'=>$email, 'password'=>$password])) {
                return response()->json([
                    'response' => 'error',
                    'message' => 'Password or email is invalid',
                    'token'=>$token
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
    public function login(Request $request){
        $user = \App\User::where('email', $request->email)->get()->first();
        if ($user && \Hash::check($request->password, $user->password)){
            $token = self::getToken($request->email, $request->password);
            $user->auth_token = $token;
            $user->save();
            $response = ['success'=>true, 'data'=>['id'=>$user->id,'auth_token'=>$user->auth_token,'name'=>$user->name, 'email'=>$user->email]];
        }
        else{
            $response = ['success'=>false, 'data'=>'Record doesnt exists'];
        }
        return response()->json($response, 201);
    }
    public function register(Request $request)
    {
        $payload = [
            'password'=>\Hash::make($request->password),
            'email'=>$request->email,
            'name'=>$request->name,
            'auth_token'=> ''
        ];
        $user = new \App\User($payload);
        if ($user->save()){
            $token = self::getToken($request->email, $request->password); // generate user token
            if (!is_string($token))  return response()->json(['success'=>false,'data'=>'Token generation failed'], 201);
            $user = \App\User::where('email', $request->email)->get()->first();
            $user->auth_token = $token; // update user token
            $user->save();
            $response = ['success'=>true, 'data'=>['name'=>$user->name,'id'=>$user->id,'email'=>$request->email,'auth_token'=>$token]];
        }
        else{
            $response = ['success'=>false, 'data'=>'Couldnt register user'];
        }
        return response()->json($response, 201);
    }
}
