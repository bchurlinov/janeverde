<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::get('/search', function () {
    return view('search_page');
});

Route::get('/view', function () {
    return view('details_page');
});

Route::get('/auth', function () {
    return view('auth_page');
});





Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->middleware('verified')->name('home');
Route::get('/checkid', function(){
    echo "made golo";
})->middleware('auth');
