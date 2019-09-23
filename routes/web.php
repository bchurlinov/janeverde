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

Route::get('/home', 'HomeController@index')->middleware('verified')->name('home');

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
Route::get('/manageproducts', 'ProductsController@manageProducts')->middleware('verified');

//remove product
Route::post('/pdelete', 'ProductsController@deleteProduct')->middleware('verified');
//restore product
Route::post('/prestore', 'ProductsController@restoreProduct')->middleware('verified');