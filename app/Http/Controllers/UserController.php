<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
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
            }
            //create the return array for user's statistics
            $usersData = ["verified" => $verified, "pending" => $pending, "noIDUploaded" => $noIDUploaded, "denied" => $denied, "total" => $total];

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
     * get all users that are queued up for verification
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getUsersForVerification(){
        $verificationPendingUsers = User::where('is_verified', 2)->get();
        return view('admin.usersVerification')->with('users', $verificationPendingUsers);
    }
}
