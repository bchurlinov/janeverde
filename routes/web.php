<?php

use App\Product;
use App\Favorite;
use App\User;


Route::get('/pp', function(){
    $fav = Favorite::where('user_id', '=', 19)->get();
    dd($fav);
    

});

Route::get('paypal/express-checkout', 'PaypalController@expressCheckout')->name('paypal.express-checkout');
Route::get('paypal/express-checkout-success', 'PaypalController@expressCheckoutSuccess');
Route::post('paypal/notify', 'PaypalController@notify');
Route::get('paypal/cancelsubscription', 'PaypalController@cancelRecurringSubscription');

//hc = hemp or cannabis
Route::get('/{hc}/{cat}/{subcat}/search', 'ProductsController@index')->middleware('cookies');

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

//===== IN LICENCE APPROVAL AND DECLINE ROUTES
Route::get('/inlicences', 'LicencesController@getInLicences')->middleware('cookies', 'verified');
//approve user agricultural licence
Route::post('/inapprove', 'LicencesController@inapprove')->middleware('cookies', 'verified');
//decline user picture id
Route::post('/indecline', 'LicencesController@indecline')->middleware('cookies', 'verified');
//============END IN LICENCE ROUTES

//===== BU LICENCE APPROVAL AND DECLINE ROUTES
Route::get('/bulicences', 'LicencesController@getBuLicences')->middleware('cookies', 'verified');
//approve user business licence
Route::post('/buapprove', 'LicencesController@buapprove')->middleware('cookies', 'verified');
//decline user picture id
Route::post('/budecline', 'LicencesController@budecline')->middleware('cookies', 'verified');
//============END BU LICENCE ROUTES

//===== SUPPORTING DOCUMENTS APPROVAL AND DECLINE ROUTES
Route::get('/sdlicences', 'LicencesController@getSdLicences')->middleware('cookies', 'verified');
//approve user business licence
Route::post('/sdapprove', 'LicencesController@sdapprove')->middleware('cookies', 'verified');
//decline user picture id
Route::post('/sddecline', 'LicencesController@sddecline')->middleware('cookies', 'verified');
//============END SUPPORTING DOCUMENTS ROUTES

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

// change your existing app route to this:
// we are basically just giving it an optional parameter of "anything"
// Route::get('/{path?}', function($path = null){
//     return View::make('app');
// })->where('path', '.*'); 
//regex to match anything (dots, slashes, letters, numbers, etc)

Route::get('/', function(){
    return view('home');
})->middleware('cookies');

Route::get('/privacy-policy', function () {
    return view('privacy_policy');
});

Route::get('/terms-of-use', function () {
    return view('terms_of_use');
});

//by default, redirect to /cannabis, otherwise, hemp. redirect to /cannabis if other category is entered that does not comply with hemp/cannabis
// Route::get('/{type?}', function($type = ""){
//     if($type != "" && ($type == "cannabis" || $type == "hemp")){
//         if(session()->get('type') == null){
//             session()->put('type', 'hemp');
//         }

//         if($type == "cannabis"){
//             //if there is no cookie( no user is logged ), we must not allow to go to cannabis
//             if(empty($_COOKIE['_main'])){
//                 session()->put('type', 'hemp');
//                 return redirect('/hemp');
//             }
//             else {
//                 //set hemp or cannabis
//                 session()->put('type', $type);
//                 return view('home');
//             }
//         }
//         else{
//             //set hemp or cannabis
//             session()->put('type', $type);
//             return view('home');

//         }
//     }
//     else{
//         return redirect('/hemp');
//     }
// })->middleware('cookies');



