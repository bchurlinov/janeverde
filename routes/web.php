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

Route::get('/search', 'ProductsController@index');

Route::get('/view/{id}', 'ProductsController@view');

Route::get('/auth', function () {
    return view('auth_page');
});

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->middleware('auth')->name('home');

//user dashboard, protected by auth middleware
Route::get('dashboard', 'UserController@index')->middleware('verified');

//upload user image
Route::post('image-upload', 'UserController@uploadID')->middleware('verified')->name('uploadID');

//get all user purchased products (buyer)
Route::get('/myproducts', 'UserController@buyerPurchasedProducts')->middleware('verified');

//get all users for verification
Route::get('/usersverification', 'UserController@getUsersForVerification')->middleware('verified');

//get all users for deletion
Route::get('/usersmanagement', 'UserController@getUsersForManagement')->middleware('verified');

//approve user picture ID
Route::post('/approve', 'UserController@approve')->middleware('verified');

//decline user picture id
Route::post('/decline', 'UserController@decline')->middleware('verified');

//soft delete a user
Route::post('/delete', 'UserController@delete')->middleware('verified');

//restore a user
Route::post('/restore', 'UserController@restore')->middleware('verified');

//get all products for management
Route::get('/manageposts', 'ProductsController@manageProducts')->middleware('verified');

//remove product
Route::post('/pdelete', 'ProductsController@deleteProduct')->middleware('verified');
//restore product
Route::post('/prestore', 'ProductsController@restoreProduct')->middleware('verified');

//change user password, view only
Route::get('/changePassword', function(){ return view('auth.changepassword'); })->middleware('verified');

//route for form user update
Route::post('/changePassword','UserController@changePassword')->middleware('verified')->name('changePassword');

//view where personal details page is shown
Route::get('/settings', function() { return view ('auth.settings'); })->middleware('verified');

//post route to update user settings
Route::post('/settings', 'UserController@settings')->middleware('verified');

//update product view
Route::get('/pupdate/{id}', 'ProductsController@getProductDetailsForEdit')->middleware('verified');

//perform product update
Route ::post('/pupdate', 'ProductsController@updateProduct')->middleware('verified');

use App\Product;
use App\Countries;
Route::get('/countries', function(){
    $allProducts = Product::all();
    $allCountries = Countries::all()->toArray();
    $countries = [];
    foreach($allCountries as $country){
        $countries[$country['id']] = $country['full_country'];
    }

    foreach($allProducts as $product){
        $pr = Product::find($product->id);
        $pr->location = $countries[rand(1, 58)];
        $pr->save();
    }
    echo "done";
});