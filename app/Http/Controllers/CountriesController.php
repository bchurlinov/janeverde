<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Countries;
class CountriesController extends Controller
{
    public function __construct(){
        app('App\Http\Controllers\UserController')::checkHempOrCannabis();
    }
    /**
     * Get the country based on the user's ip, or if it was saved previously in session
     * @return array $country the parsed country
     */
    public static function getCountry(){
        $country = ["dropdown" => "all", "fullName" => "All states"];

        if(empty($_COOKIE['country'])){
            $details = self::locateCountryByIp();
            if(!empty($details->region)){
                $country = self::processGeolocatedIp($details);
            }
            setcookie("country", $country['dropdown'], time() + 60 * 60 * 24 * 30, "/");
        }
        else{
            //check if the value is present in the database
            $cookie = $_COOKIE['country'];
            $searchInDb = Countries::where('name', '=', $cookie)->get();
            if(count($searchInDb) == 0){
                $details = self::locateCountryByIp();
                if(!empty($details->region)){
                    $country = self::processGeolocatedIp($details);
                }
                setcookie("country", $country['dropdown'], time() + 60 * 60 * 24 * 30, "/");
            }
            else{
                $country = ["dropdown" => $searchInDb[0]['name'], "fullName" => ucfirst($searchInDb[0]['full_country'])];
            }
        }

        return $country;
    }

    public static function processGeolocatedIp($details){
        if(!empty($details->region)){
            $searchInDb = Countries::where('full_country', 'LIKE', $details->region)->get();
            return count($searchInDb) > 0 ? ["dropdown" => $searchInDb[0]['name'], "fullName" => ucfirst($searchInDb[0]['full_country'])] : ["dropdown" => "all", "fullName" => "All states"];
        }
        return ["dropdown" => "all", "fullName" => "All states"];
    }

    public static function locateCountryByIp(){
        //if there is no cookie, get it from the user's ip
        if (isset($_SERVER['HTTP_CLIENT_IP'])){
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
        elseif(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else{
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        //$ip = '208.72.68.0';
        return json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
    }

    public function setCountry(Request $request){
        $country = $request->get('c');
        $searchInDb = Countries::where('name', '=', $country)->get();
        if(count($searchInDb) == 0){
            setcookie("country", 'all', time() + 60 * 60 * 24 * 30, "/");
        }
        else{
            setcookie("country", $searchInDb[0]['name'], time() + 60 * 60 * 24 * 30, "/");
        }
    }
}
