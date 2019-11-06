
<?php
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Product;
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['middleware' => ['jwt.auth','api-header']], function () {
    // header("Access-Control-Allow-Origin:*");
    // all routes to protected resources are registered here
    Route::get('users/list', function(){
        //load user relations, and return all of them
        $users = App\User::with('industrialLicense', 'businessLicense', 'pictureID', 'country', 'supportingDocuments', 'subscription')->find(auth()->user()->id);
        $users->postsCount = app('App\Http\Controllers\UserController')::postsCount(auth()->user()->id);
        if($users->businessLicense == null){
            unset($users->businessLicense);
            $users->business_license = [
                'id' => 0,
                'user_id' => auth()->user()->id,
                'licensenumber' => '0',
                'expiration_date' => '1970-01-01',
                'img1' => '',
                'img2' => '',
                'img3' => '',
                'verified' => -10
            ];
        }
        if($users->industrialLicense == null){
            unset($users->industrialLicense);
            $users->industrial_license = [
                'id' => 0,
                'user_id' => auth()->user()->id,
                'licensenumber' => '0',
                'expiration_date' => '1970-01-01',
                'img1' => '',
                'img2' => '',
                'img3' => '',
                'verified' => -10
            ];
        }

        if($users->pictureID == null){
            unset($users->pictureID);
            $users->picture_i_d = [
                'id' => 0,
                'user_id' => auth()->user()->id,
                'image' => '',
                'verified' => -10,
            ];
        }

        if($users->supportingDocuments == null){
            unset($users->supportingDocuments);
            $users->supporting_documents = [
                'id' => 0,
                'user_id' => auth()->user()->id,
                'img1' => '',
                'img2' => '',
                'img3' => '',
                'img4' => '',
                'img5' => '',
                'verified' => -10
            ];
        }

        if($users->subscription == null){
           unset($users->subscription);
           $users->subscription = [
               'id' => 0,
               'user_id' => auth()->user()->id,
               'title' => '0',
               'price' => '0',
               'payment_status' => '0',
               'recurring_id' => '0',
               'active' => -10
           ];
        }
        $users->canPost = 0;
        //can the user post?
        if($users->verification_step_1 == 1){
            $users->canPost = 1;
            $year = date('Y');
            $month = date('m');
            $startday = "01";
            $endDay = date('t');
            $from = date("$year-$month-$startday");
            $to = date("$year-$month-$endDay");
            $res = Product::where('user_id', '=', auth()->user()->id)->whereBetween('created_at', [$from, $to])->get();
            if($res->count() == 3){
                $users->canPost = 0;
            }
        }

        if($users->verification_step_1 == 1 && $users->picture_i_d['verified'] == 1 &&
           $users->subscription['id'] > 0 && $users->subscription['active'] == 1){
            $users->canPost = 1;
        }

        if($users->verification_step_1 == 1 && $users->picture_i_d['verified'] == 1 &&
           $users->business_license['verified'] == 1 && $users->industrial_license['verified'] == 1){
            $users->canPost = 1;
        }

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

    //add Industrial License
    Route::post('/user/newInLicence', 'UserController@newInLicence');

    //add Business License
    Route::post('/user/newBuLicence', 'UserController@newBuLicence');

    //add picture ID
    Route::post('/user/verificationDataId', 'UserController@newPictureId');

    //edit user details <- SAMO PASSWORD KJE MOZI DA SE MENUVA
    Route::post('/user/edit', 'UserController@editUserPictureId');

    //reactivate product
    Route::post('/user/reactivatepost', 'ProductsController@reactivateProduct');

    //verification step 1
    Route::post('/verificationstep1', 'UserController@vf1');

    //supporting documents
    Route::post('/user/supportingdocuments', 'UserController@supportingDocuments');

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