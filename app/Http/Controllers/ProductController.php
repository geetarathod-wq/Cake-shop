<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function index()
    {
        // Fetch all products with their categories
        $products = Product::with('category')->get();

        // Debug: uncomment the next line to see what's being fetched
        // dd($products);

        return view('welcome', compact('products'));
    }
}