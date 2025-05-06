<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::with('category')           // eager loading caz we use for loop
            ->active()                                          // active retrieve only active products, we define it in Product model
            ->take(6)->get();                                   // get only first 6 products
        return view('front.home', compact('products'));
    }
}


