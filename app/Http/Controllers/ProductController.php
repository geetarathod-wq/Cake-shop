<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        // Get all products (you can later change to featured)
        $products = Product::with('category')->get();

        // For the slider, pick a few (e.g., first 6)
        $sliderProducts = $products->take(6);

        return view('welcome', compact('products', 'sliderProducts'));
    }
}