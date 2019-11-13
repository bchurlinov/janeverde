<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Countries;
use App\Categories;
use App\Subcategories;
use Illuminate\Support\Str; //for random image name
use Tymon\JWTAuth\Facades\JWTAuth;
use App\User;
use App\Flagged;
use App\Hide;
use App\Favorite;

class ProductsController extends Controller
{
    public $country;

    /**
     * Get all products from database
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request){

        $postFields = $request->all();
        $horcTypes = ['cannabis', 'hemp'];
        $allProducts = [];

        if(empty($_COOKIE['_main']) && auth()->user() != null){
            session()->put('type', 'hemp');
            $hOrC = "hemp";
        }
        else{
            $allowed = ["hemp", "cannabis"];
            $hOrC = request()->segment(1) != null ? request()->segment(1) : null;
            if(!in_array($hOrC, $allowed)){
                session()->put('type', 'hemp');
                return redirect('/');
            }
        }

        $category = request()->segment(2) != null ? request()->segment(2) : null;
        $subcategory = request()->segment(3) != null ? request()->segment(3) : null;
        $search = request()->segment(4) != null ? request()->segment(4) : null;

        $conditions = [
            ['is_deleted', '=', 0],
            ['type', '=', $hOrC]
        ];

        //check if category is a valid one
        if($category != 0){
            $cat = Categories::where('number', '=', $category)->get();
            if($cat->count() == 0){
                //category doesnt exist
                return redirect('/');
            }
            else{
                $conditions[] = ["category_id", "=", $category];
            }
        }

        //check if subcategory and its parent category is a valid one
        if($subcategory != 0){
            $subcat = Subcategories::where([['number', '=', $subcategory], ['category_id', '=', $category]])->get();

            if($subcat->count() == 0){
                //category doesnt exist
                return redirect('/');
            }
            else{
                $conditions[] = ["subcategory_id", "=", $subcategory];
            }
        }

        if($search == null || $search != "search"){
            return redirect('/');
        }

        //all is fine with params, proceed with country
        $country = json_decode(session()->get('country'), true)['dropdown'];

        //check the country
        $findCountry = Countries::where('name', '=', $country)->get();
        if(count($findCountry) == 0) $country = "all";

        $keyword = "";

        if($country != "all"){
            $conditions[] = ['state', '=', $country];
        }

        //if verified only is clicked, add another case
        if(session()->get('searchType') != 'null' && session()->get('searchType') == 'verifiedOnly') {
            $conditions[] = ['verified', '=', 1];
        }

        if(count($postFields) == 0){
            //only /search is clicked
            $allProducts = Product::with('userAlter')->where($conditions)->orderBy('created_at', 'desc')->paginate(6);
        }
        else{
            $keyword = $request->get('keyword');
            $allProducts = $keyword == null ? $allProducts = Product::with('userAlter')->where($conditions)->orderBy('created_at', 'desc')->paginate(6) :
                                                             Product::with('userAlter')->search($keyword)->where($conditions)->orderBy('created_at', 'desc')->paginate(6);
        }
        //return them to the view
        return view('search_page')->with(['products' => $allProducts, "keyword" => $keyword]);
    }

    /**
     * manage products
     * @param bool $redirect whether it comes from a form or normal route
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function manageProducts($redirect = false){
        //get the products sorted by latest
        $allProducts = Product::orderBy('created_at', 'desc')->get();
        $notDeleted = $deleted = [];
        foreach($allProducts as $product){
            $product->is_deleted == 0 ? $notDeleted[] = $product : $deleted[] = $product;
        }
        if($redirect){
            //coming from delete, we need to redirect only
            return redirect('/manageposts')->with(['products'=> $notDeleted, "deleted" => $deleted]);
        }
        //return them to the view
        return view('admin.productsmanagement')->with(['products'=> $notDeleted, "deleted" => $deleted]);
    }

    public function setflag(Request $request){
        $validate = $request->validate([
            'c' => 'required|numeric'
        ]);
        //check if user is logged
        $user = 0;
        if(empty($_COOKIE['_main']) && auth()->user() == null){
            $user = 0;
        }
        else{
            $user = auth()->user() != null ? auth()->user()->id : $_COOKIE['main'];
        }
        $product = Product::find($request->get('c'));

        if($product != null){
            //product is real, proceed with flagging
            if($user > 0){
                $usr = User::find($user);
                //if the user exists, then add to database
                if($user != null){
                    $userId = $usr->id;
                    //check the flagged table
                    $flag = Flagged::where('user_id', '=', $userId)->get();
                    if(count($flag) == 0){
                        $new = new Flagged;
                        $new->user_id = $userId;
                        $new->product_id = $request->get('c');
                        $new->save();
                        return 1;
                    }
                    else{
                        $new = Flagged::find($flag[0]['id']);
                        $p = explode(",", $new->product_id);
                        if(in_array($request->get('c'), $p)){
                            unset($p[array_search($request->get('c'), $p)]);
                        }
                        else{
                            $p[] = $request->get('c');
                        }
                        $p = implode(',', $p);
                        $new->product_id = $p;
                        $new->save();
                        
                        $sess = session()->get('flagged');
                         $p = explode(",", $sess);
                         if(in_array($request->get('c'), $p)){
                             unset($p[array_search($request->get('c'), $p)]);
                         }
                         else{
                             $p[] = $request->get('c');
                         }
                         $p = implode(',', $p);
                         session()->put('flagged', $p);
                        
                        return 1;
                    }
                }
                else{
                     //no user is set, we set it in session only
                     $sess = session()->get('flagged');
                     $p = explode(",", $sess);
                     if(in_array($request->get('c'), $p)){
                         unset($p[array_search($request->get('c'), $p)]);
                     }
                     else{
                         $p[] = $request->get('c');
                     }
                     $p = implode(',', $p);
                     session()->put('flagged', $p);
                    return 1;
                }
            }
            else{
                //no user is set, we set it in session only
                $sess = session()->get('flagged');
                $p = explode(",", $sess);
                if(in_array($request->get('c'), $p)){
                    unset($p[array_search($request->get('c'), $p)]);
                }
                else{
                    $p[] = $request->get('c');
                }
                $p = implode(',', $p);
                session()->put('flagged', $p);
                return 1;
            }
        }
        return 1;
    }

    public function setHide(Request $request){
        $validate = $request->validate([
            'c' => 'required|numeric'
        ]);
        //check if user is logged
        $user = 0;
        if(empty($_COOKIE['_main']) && auth()->user() == null){
            $user = 0;
        }
        else{
            $user = auth()->user() != null ? auth()->user()->id : $_COOKIE['main'];
        }
        
        $product = Product::find($request->get('c'));

        if($product != null){
            //product is real, proceed with flagging
            if($user > 0){
                $usr = User::find($user);
                //if the user exists, then add to database
                if($user != null){
                    $userId = $usr->id;
                    //check the flagged table
                    $flag = Hide::where('user_id', '=', $userId)->get();
                    if(count($flag) == 0){
                        $new = new Hide;
                        $new->user_id = $userId;
                        $new->product_id = $request->get('c');
                        $new->save();
                        return 1;
                    }
                    else{
                        $new = Hide::find($flag[0]['id']);
                        $p = explode(",", $new->product_id);
                        if(in_array($request->get('c'), $p)){
                            unset($p[array_search($request->get('c'), $p)]);
                        }
                        else{
                            $p[] = $request->get('c');
                        }
                        $p = implode(',', $p);
                        $new->product_id = $p;
                        $new->save();
                        
                         $sess = session()->get('hide');
                        $p = explode(",", $sess);
                        if(in_array($request->get('c'), $p)){
                            unset($p[array_search($request->get('c'), $p)]);
                        }
                        else{
                            $p[] = $request->get('c');
                        }
                        $p = implode(',', $p);
                        session()->put('hide', $p);
                        
                        return 1;
                    }
                }
                else{
                     //no user is set, we set it in session only
                     if(session()->get('hide') == null){
                        session()->put('hide', $product->id);
                     }
                     else{
                        $sess = session()->get('hide');
                        $p = explode(",", $sess);
                        if(in_array($request->get('c'), $p)){
                            unset($p[array_search($request->get('c'), $p)]);
                        }
                        else{
                            $p[] = $request->get('c');
                        }
                        $p = implode(',', $p);
                        session()->put('hide', $p);
                     }

                    return 1;
                }
            }
            else{
                //no user is set, we set it in session only
                $sess = session()->get('hide');
                $p = explode(",", $sess);
                if(in_array($request->get('c'), $p)){
                    unset($p[array_search($request->get('c'), $p)]);
                }
                else{
                    $p[] = $request->get('c');
                }
                $p = implode(',', $p);
                session()->put('hide', $p);
                return 1;
            }
        }
        return 1;
    }

    public function setfavorite(Request $request){
        $validate = $request->validate([
            'c' => 'required|numeric'
        ]);
        //check if user is logged
        $user = 0;
        if(empty($_COOKIE['_main']) && auth()->user() == null){
            $user = 0;
        }
        else{
            $user = auth()->user() != null ? auth()->user()->id : $_COOKIE['main'];
        }
        
        $product = Product::find($request->get('c'));

        if($product != null){
            //product is real, proceed with flagging
            if($user > 0){
                $usr = User::find($user);
                //if the user exists, then add to database
                if($user != null){
                    $userId = $usr->id;
                    //check the flagged table
                    $flag = Favorite::where('user_id', '=', $userId)->get();
                    if(count($flag) == 0){
                        $new = new Favorite;
                        $new->user_id = $userId;
                        $new->product_id = $request->get('c');
                        $new->save();
                        return 1;
                    }
                    else{
                        $new = Favorite::find($flag[0]['id']);
                        $p = explode(",", $new->product_id);
                        if(in_array($request->get('c'), $p)){
                            unset($p[array_search($request->get('c'), $p)]);
                        }
                        else{
                            $p[] = $request->get('c');
                        }
                        $p = implode(',', $p);
                        $new->product_id = $p;
                        $new->save();
                        $sess = session()->get('favorite');
                        
                         $p = explode(",", $sess);
                         if(in_array($request->get('c'), $p)){
                             unset($p[array_search($request->get('c'), $p)]);
                         }
                         else{
                             $p[] = $request->get('c');
                         }
                         $p = implode(',', $p);
                         session()->put('favorite', $p);
                        return 1;
                    }
                }
                else{
                     //no user is set, we set it in session only
                     $sess = session()->get('favorite');
                     $p = explode(",", $sess);
                     if(in_array($request->get('c'), $p)){
                         unset($p[array_search($request->get('c'), $p)]);
                     }
                     else{
                         $p[] = $request->get('c');
                     }
                     $p = implode(',', $p);
                     session()->put('favorite', $p);
                    return 1;
                }
            }
            else{
                //no user is set, we set it in session only
                $sess = session()->get('favorite');
                     $p = explode(",", $sess);
                     if(in_array($request->get('c'), $p)){
                         unset($p[array_search($request->get('c'), $p)]);
                     }
                     else{
                         $p[] = $request->get('c');
                     }
                     $p = implode(',', $p);
                     session()->put('favorite', $p);
                return 1;
            }
        }
        return 1;
    }

    /**
     * set cannabis or hemp from the leftMenu buttons
     * @param Request $request
     */
    public function sethc(Request $request){
        $horc = $request->get('c');
        
        if(empty($_COOKIE['_main']) && auth()->user() == null){
            session()->put('type', 'hemp');
        }
        else{
            $sess = session()->get('type');
            if($sess == null){
                session()->put('type', 'hemp');
            }
            else{
                if($horc != 'hemp' || $horc != "cannabis"){
                    session()->put('type', 'hemp');
                }
                else{
                    session()->put('type', $horc);
                }
            }
        }


        if($horc != "hemp" && $horc != "cannabis"){
            session()->put('type', 'hemp');
            echo "hemp";
        }
        else{
            if(empty($_COOKIE['_main']) && auth()->user() == null){
                $horc = 'hemp';
                session()->put('type', 'hemp');
            }
            else{
                session()->put('type', $horc);
            }
        }
        
        return back();
    }

    public function setav(Request $request){
        $setav = $request->get('c');
        //['viewAll', 'verifiedOnly']; searchType
        $setav != "viewAll" && $setav != 'verifiedOnly' ? session()->put('searchType', 'viewAll') : session()->put('searchType', $setav);
        echo $setav;
    }

    /**
     * soft delete a product
     * @param int $id the id of the product
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function deleteProduct(Request $request){
        $product = Product::find($request->input('id'));
        $product->is_deleted = 1;
        $product->save();
        return $this->manageProducts(true);
    }

    /**
     * restore a product
     * @param int $id the id of the product
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function restoreProduct(Request $request){
        $product = Product::find($request->input('id'));
        $product->is_deleted = 0;
        $product->save();
        return $this->manageProducts(true);
    }

    /**
     * view product updates
     * @param int $id the product id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view($id){
        //get the session to see whether is set view all or verified only
        $searchType = session()->get('searchType');

        //get the country
        $country = session()->get('country');
        if($country != null){

        }
        $previous = Product::where('id', '<', $id)->max('id');
        $next = Product::where('id', '>', $id)->min('id');

        if($searchType == 'verifiedOnly'){
            /*
            in case of verified only, we need to filter out based on the user() relation.
            first, we find the user by id, gotten previously by $previous / $next,
            then using lazy loading, from the relation we extract whether the user is verified or not
            and return the id, if it doesnt exist, we assign null to it
            */
            $prev = Product::find($previous);
            $previous = $prev != null ? $prev->user()->where('is_verified', '=', 1)->max('id') : null;
            $nex = Product::find($next);
            $next = $nex != null ?  $nex->user()->where('is_verified', '=', 1)->max('id') : null;
        }
        //get previous url, match it with url segments
        $preurl = url()->previous();
        $prev = "/";
        if(strpos($preurl, "/search")){
            $preurl = explode("/", url()->previous());
            //came from search
            $prev = "/".$preurl[count($preurl) - 3]."/".$preurl[count($preurl) - 2]."/".$preurl[count($preurl) - 1];
            //put this in session, we will need it
            session()->put('goToPrevious', $prev);
        }
        $product = Product::with('user', 'country', 'category')->find($id);

        //flagged, hidden or favorited by user
        $fhf = self::checkfhf();
        return view('details_page')->with(['product' => $product, 'previous' => $previous, "next" => $next, 'fhf' => $fhf]);
    }

    /**
     * get product details for edit
     * @param int $id the product id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getProductDetailsForEdit($id){
        return view('auth.editProduct')->with('product', Product::find($id));
    }

    /**
     * update existing product
     * @param Request $request form data
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProduct(Request $request){
        $validateData = $request->validate([
            'id' => 'numeric|required',
            'title' => 'string|required',
            'description' => 'required'
        ]);
        $id = $request->input('id');
        $product = Product::find($id);
        $product->title = $request->input('title');
        $product->description = $request->input('description');
        $product->save();
        return redirect()->back()->with('success', 'Product successfully updated');
    }

    /**
     * Get the name of the category
     * @param int $id the id of the category
     * @return mixed
     */
    public static function getCategoryName($id){
        $cat = Categories::where('number', $id)->get();
        return count($cat) == 0 ? "General" : $cat[0]['name'];
    }


    public function newProduct(){
        //check the validity of user if he can post or not
        $loggedUserId = auth()->user()->id;
        /*
        phone_calls: true
        text_sms: true
        */
        //load the user with all his relations
        $canPost = false;
        $threeAMonth = 0;

        $users = User::with('industrialLicense', 'businessLicense', 'pictureID', 'country', 'supportingDocuments', 'subscription')->find(auth()->user()->id);

        if($users->verification_step_1 == 1){
            $canPost = 1;
            $threeAMonth = 1;
        }
        if($users->verification_step_1 == 1 && $users->pictureID != null && $users->pictureID->verified == 1 &&
            $users->businessLicense != null && $users->businessLicense->verified == 1 &&
            $users->subscription != null && $users->subscription->id > 0 && $users->subscription->active == 1){
            $canPost = 1;
            $threeAMonth = 2;
        }
        if($users->verification_step_1 == 1 && $users->pictureID != null && $users->pictureID->verified == 1 &&
            $users->businessLicense != null && $users->businessLicense->verified == 1 &&
            $users->industrialLicense != null && $users->industrialLicense->verified == 1){
            $canPost = 1;
            $threeAMonth = 2;
        }

        if($threeAMonth == 0){
            return json_encode(['status' => 'failed', 'reason' => 'you are not allowed to post']);
        }
        if($threeAMonth == 1){
            $year = date('Y');
            $month = date('m');
            $startday = "01";
            $endDay = date('t');
            $from = date("$year-$month-$startday");
            $to = date("$year-$month-$endDay");
            $res = Product::where('user_id', '=', auth()->user()->id)->whereBetween('created_at', [$from, $to])->get();
            if($res->count() == 3){
                return json_encode(['status' => 'failed', 'reason' => 'you have reached your monthly limit']);
            }
        }

        if(!$canPost){
            return json_encode(['status' => 'failed', 'reason' => 'you are not allowed to post']);
        }

        //header("Access-Control-Allow-Origin:*");
        request()->validate([
            'title' => 'required', 
            'description' => 'required', 
            'price' => 'required|numeric', 
            'country' => 'required', 
            'type' => 'required', 
            'category' => 'required|numeric', 
            'image' => 'nullable',
            'phone' => 'nullable',
            'contact_preferences' => 'nullable',
            'phone_calls' => 'required|boolean',
            'text_sms' => 'required|boolean'
        ]);


        //first, get country details
        $country = Countries::where('name', '=', request()->get('country'))->get()->first();
        if($country == null){
            echo json_encode(['status' => 'failed', 'reason' => 'invalid country']);
            return;
        }
        //all is fine with the country, check category
        $subcategory = Subcategories::where('number', '=', request()->get('category'))->get()->first();
        if($subcategory == null){
            echo json_encode(['status' => 'failed', 'reason' => 'invalid category']);
            return;
        }
        $category = Categories::where('number', '=', $subcategory->category_id)->get()->first();
        //all is fine with category, check type
        $type = request()->get('type');

        if($type != "hemp" && $type != "cannabis"){
            echo json_encode(['status' => 'failed', 'reason' => 'invalid type']);
            return;
        }
        //all is fine with type, proceed with image

        $img = request()->get('image');
        $name = $img2 = $img3 =$img4 = $img5 = $img6 = $img7 = $img8 = $img9 = $img10 = null;

        if(!empty($img[0])){ $name = $this->processImage($img, 0); }
        if(!empty($img[1])){ $img2 = $this->processImage($img, 1); }
        if(!empty($img[2])){ $img3 = $this->processImage($img, 2); }
        if(!empty($img[3])){ $img4 = $this->processImage($img, 3); }
        if(!empty($img[4])){ $img5 = $this->processImage($img, 4); }
        if(!empty($img[5])){ $img6 = $this->processImage($img, 5); }
        if(!empty($img[6])){ $img7 = $this->processImage($img, 6); }
        if(!empty($img[7])){ $img8 = $this->processImage($img, 7); }
        if(!empty($img[8])){ $img9 = $this->processImage($img, 8); }
        if(!empty($img[9])){ $img10= $this->processImage($img, 9); }

        $phonecalls = request()->get('phone_calls');
        $textsms =  request()->get('text_sms');

        $phonecalls = $phonecalls == false ? "0" : "1";
        $textsms = $textsms == false ? ",0" : ",1";
        $prefs = $phonecalls.$textsms;

        if(request()->get('phone') == "" || request()->get('phone') == null){
            $prefs = "0,0";
        }
        
        //create Product instance, we insert new product
        $product = new Product;
        $product->user_id = $loggedUserId;
        $product->title = request()->get('title');
        $product->description = request()->get('description');
        $product->price = request()->get('price');
        $product->location = $country->full_country;
        $product->country_id = $country->id;
        $product->is_deleted = 0;
        $product->type = $type;
        $product->category_id = $category->number;
        $product->subcategory_id = $subcategory->number;
        $product->state = $country->name;
        $product->img1 = $name;
        $product->img2 = $img2;
        $product->img3 = $img3;
        $product->img4 = $img4;
        $product->img5 = $img5;
        $product->img6 = $img6;
        $product->img7 = $img7;
        $product->img8 = $img8;
        $product->img9 = $img9;
        $product->img10 = $img10;
        $product->phone = request()->get('phone');
        $product->contact_preferences = $prefs;

        //save product
        $product->save();

        $newID = $product->id;

        echo json_encode(['status' => 'success', 'id' => $newID]);
    }

    public function editProduct(){
        request()->validate([
            'id' => 'required'
        ]);

        //get user id, we need it to connect it to the product
        $loggedUserId = auth()->user()->id;

        //create Product instance, we update a product
        $product = Product::find(request()->get('id'));
        
        //if inexistent product, return an error
        if($product == null){
            return json_encode(["status" => "failed", "reason" => "The product doesn't exist"]);
        }

        //check if the user is owner of the product, if it isnt, then return an error
        if($loggedUserId != $product->user_id){
            return json_encode(["status" => "failed", "reason" => "Not allowed to edit this product"]);
        }

        //if country is not sent in form, get it from the product
        $countryname = request()->get('country') == null ? $product->state : request()->get('country');

        //get country details
        $country = Countries::where('name', '=', $countryname)->get()->first();
        if($country == null){
            echo json_encode(["status" => "failed", "reason" => "invalid country"]);
            return;
        }

        //if subcategory is not sent in the form, get it from the product
        $subcategoryname = request()->get('category') == null ? $product->subcategory_id : request()->get('category');

        //all is fine with the country, check category
        $subcategory = Subcategories::where('number', '=', $subcategoryname)->get()->first();
        if($subcategory == null){
            echo json_encode(["status" => "failed", "reason" => "invalid category"]);
            return;
        }
        $category = Categories::where('number', '=', $subcategory->category_id)->get()->first();
        
        //all is fine with category, check type
        $type = request()->get('type') == null ? $product->type : request()->get('type');

        if($type != "hemp" && $type != "cannabis"){
            echo json_encode(["status" => "failed", "reason" => "invalid type"]);
            return;
        }
        //all is fine with type, proceed with image

        $img = request()->get('image');
        $imagesForDeletion = request()->get('delete');
        //$img1 = $img2 = $img3 =$img4 = $img5 = $img6 = $img7 = $img8 = $img9 = $img10 = null;
        
        //we need to check if the images for deletion + 
        $imgCount = $img != null ? count($img) : 0;
        $deletionCount = $imagesForDeletion != null ? count($imagesForDeletion) : 0;
        $productImagesPresentCount = 0;
        
        //all product images
        $images = [];
        for($i = 0; $i < 10; $i++){
            $br = $i + 1;
            $im = "img".$br;
            $images[$i] = $product->$im;
            if($product->$im != null){
                $productImagesPresentCount += 1;
            }
        }

        $finalCount = $productImagesPresentCount - $deletionCount + $imgCount;

        if($finalCount > 10 || $finalCount < 1){
            return json_encode(["status" => "failed", "reason" => "Minimum number of images is 1 and maximum is 10"]);
        }

        if($imagesForDeletion != null){
            //there are images to delete
            foreach($imagesForDeletion as $im){
                //get the array key so we can replace the value and delete the old image
                //and set it to null
                $key = array_search($im, $images);
                $toDelete = $images[$key];
                $images[$key] = null;
                unlink(public_path().'/products/'.$toDelete);
            }
        }

        //go through the potential images for upload, if there are any
        if(count($img) > 0){
            //there are new images to upload, go through them
            foreach($img as $key => $value){
                if(!in_array($value, $images)){
                    $k = array_search(null, $images);
                    $images[$k] = $this->processImage($img, $k);
                }
            }
        }
        
        $product->user_id = $loggedUserId;
        $product->title = request()->get('title') == null ? $product->title : request()->get('title');
        $product->description = request()->get('description') == null ? $product->description : request()->get('description');
        $product->price = request()->get('price') == null ? $product->price : request()->get('price');
        $product->location = $country->full_country;
        $product->country_id = $country->id;
        $product->is_deleted = 0;
        $product->type = $type;
        $product->category_id = $category->number;
        $product->subcategory_id = $subcategory->number;
        $product->state = $country->name;
        $product->img1 = $images[0];
        $product->img2 = $images[1];
        $product->img3 = $images[2];
        $product->img4 = $images[3];
        $product->img5 = $images[4];
        $product->img6 = $images[5];
        $product->img7 = $images[6];
        $product->img8 = $images[7];
        $product->img9 = $images[8];
        $product->img10 = $images[9];
        $product->phone = request()->get('phone');
        $product->contact_preferences = request()->get('contact_preferences');

        //save product
        $product->save();

        echo json_encode(['status' => 'success']);
    }

    public function processImage($img, $index){
        $img = $img[$index];
        $img = explode(';', $img);
        $name = str_replace("name=", "", $img[1]);
        $name = explode(".", $name);
        $extension = $name[count($name) - 1];
        unset($name[count($name) - 1]);
        $name = md5(implode(".", $name)).time().".".$extension;
        $content =str_replace("base64,", "", $img[2]);
        \File::put(public_path(). '/products/' . $name, base64_decode($content));
        return $name;
    }

    public static function checkfhf(){
        //check favorites, hidden and flagged
        //first, we check if there is user
        
        $user = 0;
        if(empty($_COOKIE['_main']) && auth()->user() == null){
            $user = 0;
        }
        else{
            $user = auth()->user() != null ? auth()->user()->id : $_COOKIE['_main'];
        }
        
        $data = [
            'favorites' => [],
            'hidden' => [],
            'flagged' => []
        ];
        /*if($user == 0){
            //there is no user, check the session
            if(session()->get('flagged') != null){
                $s = explode(",", session()->get('flagged'));
                foreach($s as $v){
                    if($v != "") $data['flagged'][] = $v;
                }
            }
            if(session()->get('favorite') != null){
                $s = explode(",", session()->get('favorite'));
                foreach($s as $v){
                    if($v != "") $data['favorites'][] = $v;
                }
            }
            if(session()->get('hide') != null){
                $s = explode(",", session()->get('hide'));
                foreach($s as $v){
                    if($v != "") $data['hidden'][] = $v;
                }
            }

        }
        else{ */
            //there is user, check if it is real user
            $usr = User::find($user);
            //user is real, proceed
            if($usr != null){
                $id = $usr->id;
                $flagged = Flagged::where('user_id', '=', $id)->get();
                if(count($flagged) > 0){
                    $flagged = $flagged[0];
                    $p = array_filter(explode(",", $flagged->product_id));
                    foreach($p as $k){
                        if($k != "") $data['flagged'][] = $k;
                    }
                }                    

                $hidden = Hide::where('user_id', '=', $id)->get();
                if(count($hidden) > 0){
                    $hidden = $hidden[0];
                    $p = array_filter(explode(",", $hidden->product_id));
                    foreach($p as $k){
                        if($k != "") $data['hidden'][] = $k;
                    }
                }

                $favorites = Favorite::where('user_id', '=', $id)->get();
                if(count($favorites) > 0){
                    $favorites = $favorites[0];
                    $p = array_filter(explode(",", $favorites->product_id));
                    foreach($p as $k){
                        if($k != "") $data['favorites'][] = $k;
                    }
                }
            }
            /*else{
                //check the session, the user is not real
                if(session()->get('flagged') != null){
                    $s = explode(",", session()->get('flagged'));
                    foreach($s as $v){
                        if($v != "") $data['flagged'][] = $v;
                    }
                }
                if(session()->get('favorite') != null){
                    $s = explode(",", session()->get('favorite'));
                    foreach($s as $v){
                        if($v != "") $data['favorites'][] = $v;
                    }
                }
                if(session()->get('hide') != null){
                    $s = explode(",", session()->get('hide'));
                    foreach($s as $v){
                        if($v != "") $data['hidden'][] = $v;
                    }
                }
            } */
        //}
        return $data;
    }

    public function reactivateProduct(Request $request){
        $request->validate([
            'product_id' => 'required|numeric'
        ]);
        $user = auth()->user()->id;
        $product = Product::find($request->get('product_id'));
        
        if($product == null){
            return json_encode(["status" => "falied", "reason" => "Post doesn't exist"]);
        }

        if($user != $product->user_id){
            return json_encode(["status" => "falied", "reason" => "Permission denied"]);
        }

        $date = date("Y-m-d h:i:s");
        $product->created_at = $date;
        $product->updated_at = $date;

        $product->save();

        return json_encode(["status" => "success"]);
    }
}
