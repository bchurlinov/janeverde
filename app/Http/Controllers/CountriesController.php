<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Countries;
class CountriesController extends Controller
{
    /**
     * Get the country based on the user's ip
     * @return string $country the parsed country
     */
    public static function getCountry(){
        if (isset($_SERVER['HTTP_CLIENT_IP'])){
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
        elseif(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }else{
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        //$ip = '208.72.68.0';
        $details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));

        $country = "all";
        if(!empty($details->region)){
            $searchInDb = Countries::where('full_country', 'LIKE', $details->region)->get();
            $country = count($searchInDb) > 0 ? $searchInDb[0]['name'] : 'all';
        }
        return $country;
    }
}
