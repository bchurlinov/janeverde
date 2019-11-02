<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\IndustrialLicense;
use App\BusinessLicense;

class LicencesController extends Controller
{
    //==================================================================== INDUSTRIAL METHODS ========================================================================
    public function getInLicences($redirect = false){
        $verificationPendingLicences = IndustrialLicense::with('user', 'country')->where('verified', 2)->get();
        if($redirect){
            return redirect('/inlicences')->with('licences', $verificationPendingLicences);
        }
        return view('admin.inverification')->with('licences', $verificationPendingLicences);
    }

    public function inapprove(Request $request){
        //get the agricultural licence by id
        $licence = IndustrialLicense::find($request->input('id'));
        //update the verification status
        $licence->verified = 1;
        //save the status
        $licence->save();
        return $this->getInLicences(true);
    }

    public function indecline(Request $request){
        //get the user by id
        $licence = IndustrialLicense::find($request->input('id'));
        //remove the status, and unlink the uploaded image
        $licence->verified = -1;
        $licence->image = 0;
        $path = "/inlicence".$licence->image;
        //delete the image by calling unlink
        unlink(public_path().$path);
        $licence->image = "";
        $licence->save();
        return $this->getInLicences(true);
    }
    //==================================================================== END CULTIVATION METHODS ========================================================================

    //==================================================================== BUSINESS METHODS ========================================================================
    public function getBuLicences($redirect = false){
        $verificationPendingLicences = BusinessLicense::where('verified', 2)->get();
        if($redirect){
            return redirect('/bulicences')->with('licences', $verificationPendingLicences);
        }
        return view('admin.buverification')->with('licences', $verificationPendingLicences);
    }

    public function buapprove(Request $request){
        //get the agricultural licence by id
        $licence = BusinessLicense::find($request->input('id'));
        //update the verification status
        $licence->verified = 1;
        //save the status
        $licence->save();
        return $this->getBuLicences(true);
    }

    public function budecline(Request $request){
        //get the user by id
        $licence = BusinessLicense::find($request->input('id'));
        //remove the status, and unlink the uploaded image
        $licence->verified = -1;
        $licence->image = 0;
        $path = "/bulicence".$licence->image;
        //delete the image by calling unlink
        unlink(public_path().$path);
        $licence->image = "";
        $licence->save();
        return $this->getBuLicences(true);
    }
    //==================================================================== END BUSINESS METHODS ========================================================================
}
