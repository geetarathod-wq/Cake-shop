<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email',
            'phone'         => 'required|string',
            'address'       => 'required|string',
            'delivery_date' => 'required|date|after:today',
            'payment_method'=> 'required|in:cod,online',
            'coupon_code'   => 'nullable|string|max:50',
        ]);

        // Get cart items based on user status
        if (Auth::check()) {
            $user = Auth::user();
            $cart = $user->cart;
            if (!$cart) {
                return redirect()->route('home')->with('error', 'Your bag is empty.');
            }
            $cartItems = $cart->items()->with('product')->get();
            if ($cartItems->isEmpty()) {
                return redirect()->route('home')->with('error', 'Your bag is empty.');
            }
            // Convert to array format similar to session cart
            $cartArray = [];
            foreach ($cartItems as $item) {
                $cartArray[] = [
                    'product_id' => $item->product_id,
                    'quantity'   => $item->quantity,
                    'weight'     => $item->weight,
                    'product'    => $item->product,
                ];
            }
        } else {
            $cartArray = session()->get('cart', []);
            if (empty($cartArray)) {
                return redirect()->route('home')->with('error', 'Your bag is empty.');
            }
        }

        $orderId = null;

        DB::transaction(function () use ($request, $cartArray, &$orderId) {
            $total = 0;
            foreach ($cartArray as $item) {
                $product = $item['product'] ?? Product::findOrFail($item['product_id']);
                $total += $product->price * $item['weight'] * $item['quantity'];
            }

            $order = Order::create([
                'user_id'        => auth()->id(),
                'name'           => $request->name,
                'email'          => $request->email,
                'phone'          => $request->phone,
                'address'        => $request->address,
                'delivery_date'  => $request->delivery_date,
                'total_amount'   => $total,
                'status'         => 'pending',
                'payment_method' => $request->payment_method,
                'coupon_code'    => $request->coupon_code,
                'discount_amount'=> 0,
            ]);

            foreach ($cartArray as $item) {
                $product = $item['product'] ?? Product::findOrFail($item['product_id']);
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity'   => $item['quantity'],
                    'weight'     => $item['weight'] ?? 1,
                    'price'      => $product->price,
                ]);
            }

            $orderId = $order->id;
        });

        // Clear cart after successful order
        if (Auth::check()) {
            $user = Auth::user();
            $cart = $user->cart;
            if ($cart) {
                $cart->items()->delete(); // deletes all cart items
            }
        } else {
            session()->forget('cart');
        }

        return redirect()->route('order.success', $orderId)
                         ->with('success', 'Your order has been placed!');
    }

    public function success($id)
    {
        $order = Order::with('items.product')->findOrFail($id);
        return view('order.success', compact('order'));
    }
}