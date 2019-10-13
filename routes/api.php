
<?php
use Illuminate\Http\Request;
use Tymon\JWTAuth;
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['middleware' => ['jwt.auth','api-header']], function () {

    // all routes to protected resources are registered here  
    Route::get('users/list', function(){
        //load user relations, and return all of them
        $users = App\User::with('agriculturalLicense', 'cultivationLicense', 'industrialLicense', 'pictureID', 'products')->find(auth()->user()->id);

        $response = ['success'=>true, 'data'=>$users];
        return response()->json($response, 201);
    });

    //user logout
    Route::post('user/logout', function(Request $request){
        $this->validate($request, ['token' => 'required']);
        JWTAuth::invalidate($request->input('token'));
        echo json_encode("success");
    });
});
Route::group(['middleware' => 'api-header'], function () {

    // The registration and login requests doesn't come with tokens 
    // as users at that point have not been authenticated yet
    // Therefore the jwtMiddleware will be exclusive of them
    Route::post('user/login', 'UserController@login');
    Route::post('user/register', 'UserController@register');

});