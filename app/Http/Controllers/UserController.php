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

    public function delete(Request $request){
        $user = User::find($request->input('id'));
        //set is_deleted to 1
        $user->is_deleted = 1;
        $user->save();
        return $this->getUsersForManagement(true);
    }

    public function restore(Request $request){
        $user = User::find(explode('_', $request->input('id'))[0]);
        //set is_deleted to 0
        $user->is_deleted = 0;
        $user->save();
        return $this->getUsersForManagement(true);
    }
}
