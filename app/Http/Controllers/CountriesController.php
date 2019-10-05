<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Countries;
class CountriesController extends Controller
{
    public function __construct(){
        //app('App\Http\Controllers\UserController')::checkHempOrCannabis();
    }

    public function setCountry(Request $request){
        $country = $request->get('c');
        $searchInDb = Countries::where('name', '=', $country)->get();
        if(count($searchInDb) == 0){
            session()->put('country', json_encode(["dropdown" => "all", "fullName" => "All states"]));
            //setcookie("country", 'all', time() + 60 * 60 * 24 * 30, "/");
        }
        else{
            session()->put('country', json_encode(["dropdown" => $searchInDb[0]['name'], 'fullName' => $searchInDb[0]['full_country']]));
            //setcookie("country", $searchInDb[0]['name'], time() + 60 * 60 * 24 * 30, "/");
        }
    }
}
