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
        //===================== TYPE COOKIE =====================
        //type cookie - hemp or cannabis
        if(!empty($_COOKIE['type'])){
            $allowed = ['hemp', 'cannabis'];
            if(!in_array($_COOKIE['type'], $allowed)){
                //default one is cannabis, set it now
                session()->put('type', 'hemp');
            }
            //else, it is allowed, dont mess with it
        }
        else{
            //cookie not present, set it now
            session()->put('type', 'hemp');
        }

        //===================== PRODUCTS SEARCH COOKIE =====================
        if(session()->get('search') == 'null'){
            //no cookie is set, set a default to viewAll
            session()->put('searchType', 'viewAll');
        }
        else{
            $allowedTypes = ['viewAll', 'verifiedOnly'];
            if(!in_array(session()->get('searchType'), $allowedTypes)){
                session()->put('searchType', 'viewAll');
                //setcookie("searchType", 'viewAll', time() + 60 * 60 * 24 * 30, "/");
            }
        }

        //===================== COUNTRY COOKIE =====================
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
