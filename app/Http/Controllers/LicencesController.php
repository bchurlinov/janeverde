<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AgriculturalLicense;
use App\CultivationLicense;
use App\IndustrialLicense;

class LicencesController extends Controller
{
    //==================================================================== AGRICULTURAL METHODS ========================================================================
    public function getAgLicences($redirect = false){
        $verificationPendingLicences = AgriculturalLicense::with('user', 'country')->where('verified', 2)->get();
        if($redirect){
            return redirect('/aglicences')->with('licences', $verificationPendingLicences);
        }
        return view('admin.agverification')->with('licences', $verificationPendingLicences);
    }

    public function approve(Request $request){
        //get the agricultural licence by id
        $licence = AgriculturalLicense::find($request->input('id'));
        //update the verification status
        $licence->verified = 1;
        //save the status
        $licence->save();
        return $this->getAgLicences(true);
    }

    public function decline(Request $request){
        //get the user by id
        $licence = AgriculturalLicense::find($request->input('id'));
        //remove the status, and unlink the uploaded image
        $licence->verified = -1;
        $licence->image = 0;
        $path = $licence->image;
        //delete the image by calling unlink
        unlink(public_path($path));
        $licence->image = "";
        $licence->save();
        return $this->getAgLicences(true);
    }
    //==================================================================== END AGRICULTURAL METHODS ========================================================================

    //==================================================================== CULTIVATION METHODS ========================================================================
    public function getCuLicences($redirect = false){
        $verificationPendingLicences = CultivationLicense::with('user', 'country')->where('verified', 2)->get();
        if($redirect){
            return redirect('/culicences')->with('licences', $verificationPendingLicences);
        }
        return view('admin.cuverification')->with('licences', $verificationPendingLicences);
    }

    public function cuapprove(Request $request){
        //get the agricultural licence by id
        $licence = CultivationLicense::find($request->input('id'));
        //update the verification status
        $licence->verified = 1;
        //save the status
        $licence->save();
        return $this->getCuLicences(true);
    }

    public function cudecline(Request $request){
        //get the user by id
        $licence = CultivationLicense::find($request->input('id'));
        //remove the status, and unlink the uploaded image
        $licence->verified = -1;
        $licence->image = 0;
        $path = $licence->image;
        //delete the image by calling unlink
        unlink(public_path($path));
        $licence->image = "";
        $licence->save();
        return $this->getCuLicences(true);
    }
    //==================================================================== END CULTIVATION METHODS ========================================================================

    //==================================================================== CULTIVATION METHODS ========================================================================
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
        $path = $licence->image;
        //delete the image by calling unlink
        unlink(public_path($path));
        $licence->image = "";
        $licence->save();
        return $this->getInLicences(true);
    }
    //==================================================================== END CULTIVATION METHODS ========================================================================
}
