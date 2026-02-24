<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->get();

        // Get featured products (is_featured = true)
        $featuredProducts = Product::with('category')->where('is_featured', true)->get();

        // Fallback if no featured products exist
        if ($featuredProducts->isEmpty()) {
            $featuredProducts = $products->take(6);
        }

        return view('welcome', compact('products', 'featuredProducts'));
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)->with('category')->firstOrFail();
        return view('product.show', compact('product'));
    }
}