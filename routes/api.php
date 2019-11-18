
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
        else{
            $new = [
                'id' => $users->businessLicense->id,
                'user_id' => auth()->user()->id,
                'licensenumber' => $users->businessLicense->licensenumber,
                'expiration_date' => $users->businessLicense->expiration_date,
                'img1' => $users->businessLicense->img1,
                'img2' => $users->businessLicense->img2,
                'img3' => $users->businessLicense->img3,
                'verified' => (int)$users->businessLicense->verified
            ];
            $users->business_license = $new;
             unset($users->businessLicense);
             
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
        else{
             $new = [
                'id' => $users->industrialLicense->id,
                'user_id' => auth()->user()->id,
                'licensenumber' => $users->industrialLicense->licensenumber,
                'expiration_date' => $users->industrialLicense->expiration_date,
                'img1' => $users->industrialLicense->img3,
                'img2' => $users->industrialLicense->img2,
                'img3' => $users->industrialLicense->img3,
                'verified' => (int)$users->industrialLicense->verified
            ];
            unset($users->industrialLicense);
            $users->industrial_license = $new;
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
        else{
            $new = [
                'id' => $users->pictureID->id,
                'user_id' => auth()->user()->id,
                'image' => $users->pictureID->image,
                'verified' => (int)$users->pictureID->verified,
                ];
                 unset($users->pictureID);
                 $users->picture_i_d = $new;
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
        else{
            $new = [
                'id' => $users->supportingDocuments->id,
                'user_id' => auth()->user()->id,
                'img1' => $users->supportingDocuments->img1,
                'img2' => $users->supportingDocuments->img2,
                'img3' => $users->supportingDocuments->img3,
                'img4' => $users->supportingDocuments->img4,
                'img5' => $users->supportingDocuments->img5,
                'verified' => (int)$users->supportingDocuments->verified
                ];
            
            $users->supporting_documents = $new;
            unset($users->supportingDocuments);
        }

        if($users->subscription != null){
            $new = [
                'id' => $users->subscription->id,
               'user_id' => auth()->user()->id,
               'title' => $users->subscription->title,
               'price' => $users->subscription->price,
               'payment_status' => $users->subscription->payment_status,
               'recurring_id' => $users->subscription->recurring_id,
               'active' => (int)$users->subscription->active
                ];
            
            unset($users->subscription);
            $users->subscription = $new;
          
        }
        else{
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
        
        $users->canPost = 1;
        //can the user post?
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

        if($users->picture_i_d['verified'] == 1 &&
           $users->subscription['id'] > 0 && $users->subscription['active'] == 1){
            $users->canPost = 1;
        }

        if($users->picture_i_d['verified'] == 1 &&
           $users->business_license['verified'] == 1 && $users->industrial_license['verified'] == 1){
            $users->canPost = 1;
        }

        //force verification step to be returned as integer instead of string in some cases
        $users->verification_step_1 = (int) $users->verification_step_1;
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

    //forgot password
    Route::post('/user/forgotPassword', 'UserController@forgotPasswordReset');

    //product delete
    Route::post('/user/deleteproduct', 'ProductsController@deleteproductapi');

    //remove from saved search
    Route::post('/user/removefromsaved', 'ProductsController@removefromsaved');

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
    //forgot password
    Route::post('/user/forgotPassword', 'UserController@forgotPasswordReset');

});