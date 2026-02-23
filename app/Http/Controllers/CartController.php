<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    /**
     * Show the cart page
     */
    public function index()
    {
        return view('cart.index');
    }

    /**
     * Add product to cart with Weight Logic
     */
    public function addToCart(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        $weight = $request->input('weight', 1);
        $quantity = $request->input('quantity', 1);
        $cartKey = $id . '-' . $weight;

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] += $quantity;
        } else {
            $cart[$cartKey] = [
                "product_id" => $id,
                "name"       => $product->name,
                "quantity"   => $quantity,
                "price"      => $product->price,
                "image"      => $product->image,
                "weight"     => $weight
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Added to bag!');
    }

    /**
     * Update cart quantity (AJAX)
     */
    public function update(Request $request)
    {
        $cart = session()->get('cart', []);
        $id = $request->id;
        $quantity = $request->quantity;

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $quantity;
            session()->put('cart', $cart);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Remove item from cart
     */
    public function remove($cartKey)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$cartKey])) {
            unset($cart[$cartKey]);
            session()->put('cart', $cart);
        }
        return redirect()->back()->with('success', 'Item removed.');
    }
}