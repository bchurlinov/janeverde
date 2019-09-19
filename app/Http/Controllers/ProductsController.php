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
        //get the latest products added
        $allProducts = Product::orderBy('created_at', 'desc')->get();
        //return them to the view
        return view('search_page')->with('products', $allProducts);
    }
}
