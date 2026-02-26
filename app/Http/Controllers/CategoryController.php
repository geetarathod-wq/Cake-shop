<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of all categories.
     */
    public function index()
    {
        // Eager load products to check egg types
        $categories = Category::withCount('products')->with('products')->get();

        foreach ($categories as $category) {
            // Determine if category has eggless and/or egg products
            $category->has_eggless = $category->products->contains('egg_type', 'eggless');
            $category->has_egg     = $category->products->contains('egg_type', 'with_egg');
        }

        return view('categories.index', compact('categories'));
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