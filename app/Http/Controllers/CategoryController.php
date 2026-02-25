<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of all categories (public).
     */
    public function index()
    {
        $categories = Category::all();

        $query = Product::with('category');

        if (request()->has('category')) {
            $query->where('category_id', request('category'));
        }

        $products = $query->get();
        $sliderProducts = Product::latest()->take(6)->get();

        return view('welcome', compact('products', 'sliderProducts', 'categories'));
    }
    /**
     * Display products belonging to a specific category.
     */
    public function show($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $products = Product::where('category_id', $category->id)->with('category')->get();
        return view('categories.show', compact('category', 'products'));
    }
}
