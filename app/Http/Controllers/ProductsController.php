<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Countries;
use App\Categories;
use Illuminate\Support\Str; //for random image name

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
        $hOrC = request()->segment(1);
        $category = request()->segment(2);
        $search = request()->segment(3);
        if($hOrC == null || $category == null || $search == null){
            return redirect('/');
        }
        $categories = Categories::all()->toArray();
        $catExists = false;
        $categoryObject = "";
        foreach($categories as $cat){
            if($category == $cat['number']) {
                $catExists = true;
                $categoryObject = $cat;
            }
        }
        if($category == 0){
            $catExists = true;
        }

        //we have all route segments, move to check individual
        if(!in_array($hOrC, $horcTypes) || !$catExists || $search != "search") return redirect('/');
        //all is fine with params, proceed with country
        $country = json_decode(session()->get('country'), true)['dropdown'];

        //check the country
        $findCountry = Countries::where('name', '=', $country)->get();
        if(count($findCountry) == 0) $country = "all";

        $keyword = "";

        $whereClause = [
            ['is_deleted', '=', 0],
            ['type', '=', $hOrC]
        ];
        if($category != 0){
            $catNum = $categoryObject['number'];
            $whereClause[] = ['category_id', '=', $catNum];
        }
        if($country != "all"){
            $whereClause[] = ['state', '=', $country];
        }
        //if verified only is clicked, add another case
        if(session()->get('searchType') != 'null' && session()->get('searchType') == 'verifiedOnly') {
            $whereClause[] = ['verified', '=', 1];
        }

        if(count($postFields) == 0){
            //only /search is clicked
            $allProducts = Product::where($whereClause)->orderBy('created_at', 'desc')->paginate(6);
        }
        else{
            $keyword = $request->get('keyword');
            $allProducts = $keyword == null ? $allProducts = Product::where($whereClause)->orderBy('created_at', 'desc')->paginate(6) :
                                                             Product::search($keyword)->where($whereClause)->orderBy('created_at', 'desc')->paginate(6);
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

    /**
     * set cannabis or hemp from the leftMenu buttons
     * @param Request $request
     */
    public function sethc(Request $request){
        $horc = $request->get('c');
        if($horc != "hemp" && $horc != "cannabis"){
            session()->put('type', 'cannabis');
            echo "cannabis";
        }
        else{
            session()->put('type', $horc);
            echo $horc;
        }
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

        return view('details_page')->with(['product' => $product, 'previous' => $previous, "next" => $next]);
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
        request()->validate([
            'title' => 'required|alpha_num', //Some title
            'description' => 'required|alpha_num', //description, alpha numeric
            'price' => 'required|numeric', //strict numeric
            'country' => 'required', //like new_york, all_states, not: Arizona, New York
            'type' => 'required', //hemp or cannabis
            'category' => 'required|numeric', //integer only, check categories table for numbers
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        //give the image random str name
        $imageName = Str::random(12).'.'.request()->image->getClientOriginalExtension();

        //get user id, we need it to connect it to the product
        $loggedUserId = auth()->user()->id;

        //first, get country details
        $country = Countries::where('name', '=', request()->get('country'))->get()->first();
        if($country == null){
            echo json_encode(['status' => 'failed', 'reason' => 'invalid country']);
            return;
        }
        //all is fine with the country, check category
        $category = Categories::where('number', '=', request()->get('category'))->get()->first();
        if($category == null){
            echo json_encode(['status' => 'failed', 'reason' => 'invalid category']);
            return;
        }
        //all is fine with category, check type
        $type = request()->get('type');
        if($type != "hemp" || $type != "cannabis"){
            echo json_encode(['status' => 'failed', 'reason' => 'invalid type']);
            return;
        }
        //all is fine with type, proceed to create title
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
        $product->state = $country->name;
        $product->img1 = $imageName;
        //save product
        $product->save();

        request()->image->move(public_path('products'), $imageName);
        //return back()->with('success','You have successfully upload image.')->with('image',$imageName);
    }
}
