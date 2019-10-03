<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
        app('App\Http\Controllers\UserController')::checkHempOrCannabis();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $country = app('App\Http\Controllers\CountriesController')::getCountry();
        $cookie = empty($_COOKIE['type']) ? "cannabis" : $_COOKIE['type'];
        return view('home')->with(['country' => $country, 'cookie' => $cookie]);
    }
}
