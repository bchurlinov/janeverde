<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Countries;
use App\Categories;

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
            $whereClause[] = ['category', '=', $catNum];
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
            //setcookie("type", 'cannabis', time() + 60 * 60 * 24 * 30, "/");
            echo "cannabis";
        }
        else{
            session()->put('type', $horc);
            //setcookie("type", $horc, time() + 60 * 60 * 24 * 30, "/");
            echo $horc;
        }
    }

    public function setav(Request $request){
        $setav = $request->get('c');
        //['viewAll', 'verifiedOnly']; searchType
        $setav != "viewAll" && $setav != 'verifiedOnly' ? session()->put('searchType', 'viewAll') : session()->put('searchType', $setav);
        echo $setav;
        //$setav != "all" && $setav != 'verified' ? setcookie("searchType", 'all', time() + 60 * 60 * 24 * 30, "/") :
        //    setcookie("searchType", $setav, time() + 60 * 60 * 24 * 30, "/");
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
        $conditions = [
            "previous" => [],
            "next" => []
        ];
        $conditions['previous'][] = ['id', '<', $id];
        $conditions['next'][] = ['id', '>', $id];
        if($searchType == 'verifiedOnly'){
            $conditions['previous'][] = ['verified', '=', 1];
            $conditions['next'][] = ['verified', '=', 1];
        }

        $previous = Product::where($conditions['previous'])->max('id');
        $next = Product::where($conditions['next'])->min('id');
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
        $product = Product::find($id);
        $productCat = Categories::where('number', $product->category)->get();

        return view('details_page')->with(['product' => $product, 'previous' => $previous, "next" => $next, "category" => $productCat]);
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
}
