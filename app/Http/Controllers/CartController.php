<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Show the cart page
     */
    public function index()
    {
        if (Auth::check()) {
            // Load from database
            $cart = Auth::user()->cart;
            if (!$cart) {
                $cart = Cart::create(['user_id' => Auth::id()]);
            }
            $cartItems = $cart->items()->with('product')->get();
            // Transform to array format used by view
            $cartArray = [];
            foreach ($cartItems as $item) {
                $key = $item->product_id . '-' . $item->weight;
                $cartArray[$key] = [
                    'product_id' => $item->product_id,
                    'name'       => $item->product->name,
                    'quantity'   => $item->quantity,
                    'price'      => $item->product->price,
                    'image'      => $item->product->image,
                    'weight'     => $item->weight,
                    'id'         => $item->id, // cart_item id for updates/removal
                ];
            }
            return view('cart.index', ['cart' => $cartArray]);
        } else {
            // Guest: use session
            $cart = session()->get('cart', []);
            return view('cart.index', ['cart' => $cart]);
        }
    }

    /**
     * Add product to cart
     */
    public function addToCart(Request $request, $id)
    {
        $request->validate([
            'weight'   => 'nullable|numeric|min:0.5|max:5',
            'quantity' => 'nullable|integer|min:1',
        ]);

        $product = Product::findOrFail($id);
        $weight = $request->input('weight', 1);
        $quantity = $request->input('quantity', 1);

        if (Auth::check()) {
            // Logged in: store in database
            $cart = Auth::user()->cart;
            if (!$cart) {
                $cart = Cart::create(['user_id' => Auth::id()]);
            }
            // Check if same product + weight already exists
            $cartItem = $cart->items()
                ->where('product_id', $id)
                ->where('weight', $weight)
                ->first();
            if ($cartItem) {
                $cartItem->quantity += $quantity;
                $cartItem->save();
            } else {
                $cart->items()->create([
                    'product_id' => $id,
                    'quantity'   => $quantity,
                    'weight'     => $weight,
                ]);
            }
        } else {
            // Guest: store in session
            $cart = session()->get('cart', []);
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
                    "weight"     => $weight,
                ];
            }
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Added to bag!');
    }

    /**
     * Update quantity (AJAX)
     */
    public function update(Request $request)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $id = $request->id; // can be cart_item id (logged in) or composite key (guest)
        $quantity = $request->quantity;

        if (Auth::check()) {
            // $id is the cart_item id
            $cartItem = CartItem::findOrFail($id);
            $cartItem->quantity = $quantity;
            $cartItem->save();
        } else {
            $cart = session()->get('cart', []);
            if (isset($cart[$id])) {
                $cart[$id]['quantity'] = $quantity;
                session()->put('cart', $cart);
            }
        }

        return response()->json(['success' => true]);
    }

    /**
     * Update weight (AJAX)
     */
    public function updateWeight(Request $request)
    {
        $request->validate([
            'weight' => 'required|numeric|min:0.5|max:5',
        ]);

        $id = $request->id;
        $newWeight = $request->weight;

        if (Auth::check()) {
            $cartItem = CartItem::findOrFail($id);
            $cartItem->weight = $newWeight;
            $cartItem->save();
        } else {
            $cart = session()->get('cart', []);
            if (isset($cart[$id])) {
                $cart[$id]['weight'] = $newWeight;
                session()->put('cart', $cart);
            }
        }

        return response()->json(['success' => true]);
    }

    /**
     * Remove item from cart
     */
    public function remove($cartKey)
    {
        if (Auth::check()) {
            // $cartKey is the cart_item id
            $cartItem = CartItem::findOrFail($cartKey);
            $cartItem->delete();
        } else {
            $cart = session()->get('cart', []);
            if (isset($cart[$cartKey])) {
                unset($cart[$cartKey]);
                session()->put('cart', $cart);
            }
        }

        return redirect()->back()->with('success', 'Item removed.');
    }

    /**
     * Merge session cart into database cart (called on login)
     */
    public static function mergeSessionCartToDatabase($user)
    {
        $sessionCart = session()->get('cart', []);
        if (empty($sessionCart)) {
            return;
        }

        $cart = $user->cart;
        if (!$cart) {
            $cart = Cart::create(['user_id' => $user->id]);
        }

        foreach ($sessionCart as $item) {
            $existingItem = $cart->items()
                ->where('product_id', $item['product_id'])
                ->where('weight', $item['weight'])
                ->first();
            if ($existingItem) {
                $existingItem->quantity += $item['quantity'];
                $existingItem->save();
            } else {
                $cart->items()->create([
                    'product_id' => $item['product_id'],
                    'quantity'   => $item['quantity'],
                    'weight'     => $item['weight'],
                ]);
            }
        }

        session()->forget('cart');
    }
}