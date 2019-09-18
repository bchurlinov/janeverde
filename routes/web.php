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

//user dashboard, protected by auth middleware
Route::get('dashboard', 'UserController@index')->middleware('verified');

//upload user image
Route::post('image-upload', 'UserController@uploadID')->middleware('verified')->name('uploadID');

//get all user purchased products (buyer)
Route::get('/myproducts', 'UserController@buyerPurchasedProducts')->middleware('verified');