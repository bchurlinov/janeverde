<?php

namespace App\Http\Middleware;

use Closure;
use App\Countries;

class Cookies
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->handleCookies();

        return $next($request);
    }

    public function handleCookies(){
        //===================== TYPE =====================
        $type = session()->get('type');
        if($type == null){
            session()->put('type', 'hemp');
        }
        else{
            $allowed = ['hemp', 'cannabis'];
            if(!in_array($type, $allowed)){
                session()->put('type', 'hemp');
            }
        }
        // if(empty($_COOKIE['main']) || auth()->user() == null){
        //     if($type == null){
        //         session()->put('type', 'hemp');
        //     }
        //     else{
        //         if($type != "hemp" && $type != "cannabis"){
        //             session()->put('type', 'hemp');
        //         }
        //     }
        // }
        // else{
        //     if($type == null){
        //         session()->put('type', 'hemp');
        //     }
        //     else{
        //         if($type != "hemp" && $type != "cannabis"){
        //             session()->put('type', 'hemp');
        //         }
        //     }
        // }


        // if(empty($_COOKIE['_main'])){
        //     session()->put('type', 'hemp');
        // }
        // else{
        //     if(session()->get('type') == null){
        //         session()->put('type', 'hemp');
        //     }

        // }


        //===================== PRODUCTS SEARCH =====================
        if(session()->get('search') == 'null'){
            //no cookie is set, set a default to viewAll
            session()->put('searchType', 'viewAll');
        }
        else{
            $allowedTypes = ['viewAll', 'verifiedOnly'];
            if(!in_array(session()->get('searchType'), $allowedTypes)){
                session()->put('searchType', 'viewAll');
            }
        }

        //===================== COUNTRY =====================
        $country = ["dropdown" => "all", "fullName" => "All states"];

        if(session()->get('country') == null){
            $details = self::locateCountryByIp();
            if(!empty($details->region)){
                $country = self::processGeolocatedIp($details);
            }
            session()->put('country', json_encode($country));
        }
        else{
            //check if the value is present in the database
            $cookie = session()->get('country');
            $searchInDb = Countries::where('name', '=', $cookie)->get();
            if(count($searchInDb) == 0){
                $details = self::locateCountryByIp();
                if(!empty($details->region)){
                    $country = self::processGeolocatedIp($details);
                }
                session()->put('country', json_encode($country));
            }
            else{
                $country = ["dropdown" => $searchInDb[0]['name'], "fullName" => ucfirst($searchInDb[0]['full_country'])];
                session()->put('country', json_encode($country));
            }
        }
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
}
