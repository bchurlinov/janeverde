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
    public function index(Request $request){
        $postFields = $request->all();
        $allProducts = [];
        $keyword = "";
        if(count($postFields) == 0){
            //only /search is clicked
            $allProducts = Product::where('is_deleted', 0)->orderBy('created_at', 'desc')->paginate(6);
        }
        else{
            $keyword = $request->get('keyword');
            $allProducts = $keyword == null ? $allProducts = Product::where('is_deleted', 0)->orderBy('created_at', 'desc')->paginate(6) :
                                                             Product::search($keyword)->where('type', 'hemp')->orderBy('created_at', 'desc')->paginate(6);
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
        $previous = Product::where('id', '<', $id)->max('id');
        $next = Product::where('id', '>', $id)->min('id');
        return view('details_page')->with(['product' => Product::find($id), 'previous' => $previous, "next" => $next]);
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
