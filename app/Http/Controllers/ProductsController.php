<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class ProductsController extends Controller
{
    /**
     * Get all products from database
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        //get the products sorted by latest
        $allProducts = Product::where('is_deleted', 0)->orderBy('created_at', 'desc')->get();
        //return them to the view
        return view('search_page')->with('products', $allProducts);
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
            return redirect('/manageproducts')->with(['products'=> $notDeleted, "deleted" => $deleted]);
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

    public function view($id){
        return view('details_page')->with('product', Product::find($id));
    }
}
