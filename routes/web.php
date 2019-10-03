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

//Route::get('/', function () {
//    return redirect('/cannabis');
    //return view('home')->with('country', $country);
//});

//hc = hemp or cannabis
Route::get('/{hc}/{cat}/search', 'ProductsController@index');

Route::get('/view/{id}', 'ProductsController@view');

Route::get('/auth', function () {
    $country = app('App\Http\Controllers\CountriesController')::getCountry();
    $cookie = empty($_COOKIE['type']) ? "cannabis" : $_COOKIE['type'];
    return view('auth_page')->with(['country' => $country, 'cookie' => $cookie]);
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

Route::get('/setcountry', 'CountriesController@setCountry');

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

//update products
Route::get('/fillproducts', function(){
    $categories = Categories::all()->toArray();
    $randCategory = rand(0, 28);
    //['number'] mi treba

    $type = ['hemp', 'cannabis'];

    $countries = Countries::all()->toArray();
    $randCountry = rand(0, 58);
    //['name'] mi treba
    $products = Product::all()->toArray();
    //dd($countries);
    foreach($products as $product){
        $count = $countries[rand(0, 57)];
        $pr = Product::find($product['id']);
        $pr->type = $type[rand(0, 1)];
        $pr->category = $categories[rand(0, 28)]['number'];
        $pr->state = $count['name'];
        $pr->location = $count['full_country'];
        $pr->save();
    }
    echo "done";
});
//set hemp or cannabis
Route::get('/sethc', 'ProductsController@sethc');

//set view all or verified products only
Route::get('/setav', 'ProductsController@setav');

Route::get('/', function(){
    return redirect('/cannabis');
});

//by default, redirect to /cannabis, otherwise, hemp. redirect to /cannabis if other category is entered that does not comply with hemp/cannabis
Route::get('/{type?}', function($type = ""){
    app('App\Http\Controllers\UserController')::checkHempOrCannabis();
    $country = app('App\Http\Controllers\CountriesController')::getCountry();
    //set the products view to all as default if it wasnt set at first
    if(empty($_COOKIE['productsView'])) { setcookie("productsView", 'all', time() + 60 * 60 * 24 * 30, "/"); }
    if($type != "" && ($type == "cannabis" || $type == "hemp")){
        //set hemp or cannabis
        setcookie("type", $type, time() + 60 * 60 * 24 * 30, "/");
        return view('home')->with(['country' => $country, 'cookie' => $type]);
    }
    else{
        return redirect('/cannabis');
    }
});



