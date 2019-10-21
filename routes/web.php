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
use App\Countries;
use App\User;

//Route::get('/', function () {
//    return redirect('/cannabis');
    //return view('home')->with('country', $country);
//});

//hc = hemp or cannabis
Route::get('/{hc}/{cat}/search', 'ProductsController@index')->middleware('cookies');

Route::get('/view/{id}', 'ProductsController@view')->middleware('cookies');

Route::get('/auth', function () {
    return view('auth_page');
})->middleware('cookies');

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->middleware('cookies', 'auth')->name('home');

//user dashboard, protected by auth middleware
Route::get('dashboard', 'UserController@index')->middleware('cookies', 'verified');

//upload user image
Route::post('image-upload', 'UserController@uploadID')->middleware('cookies', 'verified')->name('uploadID');

//get all user purchased products (buyer)
Route::get('/myproducts', 'UserController@buyerPurchasedProducts')->middleware('cookies', 'verified');

//get all users for verification
Route::get('/usersverification', 'UserController@getUsersForVerification')->middleware('cookies', 'verified');

//get all users for deletion
Route::get('/usersmanagement', 'UserController@getUsersForManagement')->middleware('cookies', 'verified');

//approve user picture ID
Route::post('/approve', 'UserController@approve')->middleware('cookies', 'verified');

//decline user picture id
Route::post('/decline', 'UserController@decline')->middleware('cookies', 'verified');

//soft delete a user
Route::post('/delete', 'UserController@delete')->middleware('cookies', 'verified');

//restore a user
Route::post('/restore', 'UserController@restore')->middleware('cookies', 'verified');

//get all products for management
Route::get('/manageposts', 'ProductsController@manageProducts')->middleware('cookies', 'verified');

//remove product
Route::post('/pdelete', 'ProductsController@deleteProduct')->middleware('cookies', 'verified');
//restore product
Route::post('/prestore', 'ProductsController@restoreProduct')->middleware('cookies', 'verified');

//change user password, view only
Route::get('/changePassword', function(){ return view('auth.changepassword'); })->middleware('cookies', 'verified');

//route for form user update
Route::post('/changePassword','UserController@changePassword')->middleware('cookies', 'verified')->name('changePassword');

//view where personal details page is shown
Route::get('/settings', function() { return view ('auth.settings'); })->middleware('cookies', 'verified');

//post route to update user settings
Route::post('/settings', 'UserController@settings')->middleware('cookies', 'verified');

//update product view
Route::get('/pupdate/{id}', 'ProductsController@getProductDetailsForEdit')->middleware('cookies', 'verified');

//perform product update
Route ::post('/pupdate', 'ProductsController@updateProduct')->middleware('cookies', 'verified');

Route::get('/setcountry', 'CountriesController@setCountry')->middleware('cookies');

use App\Categories;
use App\Product;
/*
Route::get('/cats', function(){
    $cats = ["Biomass", "Concentrates", "Retail Products", "Grow Equipment", "Lab Equipment", "Promotional", "Misc",
        "Events / Promotional", "Groups / Activities", "General", "Commercial for Sale", "Commercial for Rent",
        "Farm / Land", "Grow Indoor", "Grow Outdoor", "Trimming", "Hemp Extract", "THC Extract", "Drying", "Sales",
        "Marketing", "Business", "Admin", "Design / Web", "Retail", "Distribution", "Laboratory", "Regulatory",
        "Construction"];
    $entered = [];
    for($i = 0; $i < 29; $i++){
        $cat = new Categories;
        $rand = rand(2000, 7000);
        $cat->number = $rand;
        $cat->name = $cats[$i];
        $cat->save();
        $entered[] = '/'.$rand.'/search" >'.$cats[$i].'</a></li>';
    }
    dd($entered);
});
*/
//===== AG LICENCE APPROVAL AND DECLINE ROUTES
Route::get('/aglicences', 'LicencesController@getAgLicences')->middleware('cookies', 'verified');
//approve user agricultural licence
Route::post('/agapprove', 'LicencesController@approve')->middleware('cookies', 'verified');
//decline user picture id
Route::post('/agdecline', 'LicencesController@decline')->middleware('cookies', 'verified');
//============END AG LICENCE ROUTES

//===== CU LICENCE APPROVAL AND DECLINE ROUTES
Route::get('/culicences', 'LicencesController@getCuLicences')->middleware('cookies', 'verified');
//approve user agricultural licence
Route::post('/cuapprove', 'LicencesController@cuapprove')->middleware('cookies', 'verified');
//decline user picture id
Route::post('/cudecline', 'LicencesController@cudecline')->middleware('cookies', 'verified');
//============END CU LICENCE ROUTES

//===== CU LICENCE APPROVAL AND DECLINE ROUTES
Route::get('/inlicences', 'LicencesController@getInLicences')->middleware('cookies', 'verified');
//approve user agricultural licence
Route::post('/inapprove', 'LicencesController@inapprove')->middleware('cookies', 'verified');
//decline user picture id
Route::post('/indecline', 'LicencesController@indecline')->middleware('cookies', 'verified');
//============END CU LICENCE ROUTES

//set flag on a product
Route::get('/flag', 'ProductsController@setflag')->middleware('cookies');

//hide a product
Route::get('/hide', 'ProductsController@setHide')->middleware('cookies');

//favorite a product
Route::get('/favorite', 'ProductsController@setfavorite')->middleware('cookies');

//set hemp or cannabis
Route::get('/sethc', 'ProductsController@sethc')->middleware('cookies');

//set view all or verified products only
Route::get('/setav', 'ProductsController@setav')->middleware('cookies');

//test route
Route::get('/test', 'UserController@getProductDetailsByUserIDAPI');

Route::get('/', function(){
    return redirect('/cannabis');
})->middleware('cookies');

Route::get('/usr', function(){
    //load user with all his relations: licences, picture id, and his products
    //$user = User::with('agriculturalLicense', 'cultivationLicense', 'industrialLicense', 'pictureID', 'products')->find(9);
    //dd($user);
    //load product with relations: user and country
    $p = Product::with('user', 'country', 'category')->find(51);
    dd($p);
});

//by default, redirect to /cannabis, otherwise, hemp. redirect to /cannabis if other category is entered that does not comply with hemp/cannabis
Route::get('/{type?}', function($type = ""){
    if($type != "" && ($type == "cannabis" || $type == "hemp")){
        //set hemp or cannabis
        session()->put('type', $type);
        return view('home');
    }
    else{
        return redirect('/hemp');
    }
})->middleware('cookies');



