<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        $query = Product::with('category');

        if (request()->has('category')) {
            $query->where('category_id', request('category'));
        }

        if (request('egg') == 'eggless') {
            $query->where('egg_type', 'eggless');
        }

        $products = $query->get();
        $sliderProducts = Product::latest()->take(6)->get();

        return view('welcome', compact('products', 'sliderProducts', 'categories'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $products = Product::with('category')
                    ->where('name', 'LIKE', "%{$query}%")
                    ->get();

        return view('search-results', compact('products', 'query'));
    }
}