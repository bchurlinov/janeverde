<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Countries;
use App\Categories;

class ProductsController extends Controller
{
    public $country;

    public function __construct(){
        $this->country = app('App\Http\Controllers\CountriesController')::getCountry();
        //call the user's controller to set the type, hemp or cannabis
        app('App\Http\Controllers\UserController')::checkHempOrCannabis();
    }

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

        $country = empty($_COOKIE['country']) ? "all" : $_COOKIE['country'];
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
            $whereClause[] = ['category', '=', $catNum];
        }
        if($country != "all"){
            $whereClause[] = ['state', '=', $country];
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

        $cookie = empty($_COOKIE['type']) ? "cannabis" : $_COOKIE['type'];
        //return them to the view
        return view('search_page')->with(['products' => $allProducts, "keyword" => $keyword, 'country' => $this->country, 'cookie' => $cookie]);
    }

    /**
     * manage products
     * @param bool $redirect whether it comes from a form or normal route
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function manageProducts($redirect = false){
        //get the products sorted by latest
        $allProducts = Product::orderBy('created_at', 'desc')->simplePaginate(10);
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
        $country = app('App\Http\Controllers\CountriesController')::getCountry();
        $previous = Product::where('id', '<', $id)->max('id');
        $next = Product::where('id', '>', $id)->min('id');
        //get previous url, match it with url segments
        $preurl = url()->previous();
        $prev = "/";
        if(strpos($preurl, "/search")){
            $preurl = explode("/", url()->previous());
            //came from search
            $prev = "/".$preurl[count($preurl) - 3]."/".$preurl[count($preurl) - 2]."/".$preurl[count($preurl) - 1];

        }

        return view('details_page')->with(['product' => Product::find($id), 'previous' => $previous, "next" => $next, 'country' => $country]);
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
}
