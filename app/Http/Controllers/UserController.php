<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    /**
     * get logged user details
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        $user = User::find(auth()->user()->id);
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
}
