
<?php
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['middleware' => ['jwt.auth','api-header']], function () {
    //header("Access-Control-Allow-Origin:*");
    // all routes to protected resources are registered here
    Route::get('users/list', function(){
        //load user relations, and return all of them
        $users = App\User::with('agriculturalLicense', 'cultivationLicense', 'industrialLicense', 'pictureID', 'country')->find(auth()->user()->id);

        $response = ['success'=>true, 'data'=>$users];
        return response()->json($response, 201);
    });

    //add new product route
    Route::post('user/newproduct', 'ProductsController@newProduct');

    //get user's products
    Route::post('/user/products', "UserController@getProductsAPI");

    //get product details by user id and product id
    Route::post('/user/product', 'UserController@getProductDetailsByUserIDAPI');

    //edit product route
    Route::post('/user/editproduct', 'ProductsController@editProduct');

    //add Agricultural licence
    Route::post('/user/newAgLicence', 'UserController@newAgLicence');

    //add Industrial License
    Route::post('/user/newInLicence', 'UserController@newInLicence');

    //add Cultivation License
    Route::post('/user/newCuLicence', 'UserController@newCuLicence');

    //add picture ID
    Route::post('/user/verificationDataId', 'UserController@newPictureId');

    //edit user details
    Route::post('/user/edit', 'UserController@editUserPictureId');

    //user logout
    Route::post('user/logout', function(Request $request){
        $request->validate(['token' => 'required']);
        //invalidate the token, forever (blacklisting it so it wont be reusable anymore)
        auth()->logout(true);
        //return status -> success
        echo json_encode(["status" => "success"]);
    });
});
Route::group(['middleware' => 'api-header'], function () {

    // The registration and login requests doesn't come with tokens
    // as users at that point have not been authenticated yet
    // Therefore the jwtMiddleware will be exclusive of them
    Route::post('user/login', 'UserController@login');
    Route::post('user/register', 'UserController@register');

});