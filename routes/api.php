
<?php
use Illuminate\Http\Request;
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['middleware' => ['jwt.auth','api-header']], function () {
    //header("Access-Control-Allow-Origin:*");
    // all routes to protected resources are registered here  
    Route::get('users/list', function(){
        //load user relations, and return all of them
        $users = App\User::with('agriculturalLicense', 'cultivationLicense', 'industrialLicense', 'pictureID', 'products')->find(auth()->user()->id);

        $response = ['success'=>true, 'data'=>$users];
        return response()->json($response, 201);
    });

    //add new product route
    Route::post('user/newproduct', 'ProductsController@newProduct');

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