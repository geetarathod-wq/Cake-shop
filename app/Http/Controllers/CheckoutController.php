<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validate the checkout form data
        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email',
            'phone'         => 'required|string',
            'address'       => 'required|string',
            'delivery_date' => 'required|date|after:today',
        ]);

        // 2. Get the cart from session
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('home')->with('error', 'Your bag is empty.');
        }

        // 3. Use database transaction to ensure consistency
        DB::transaction(function () use ($request, $cart) {
            // 3.1 Create the order
            $order = Order::create([
                'user_id'       => auth()->id(),
                'name'          => $request->name,
                'email'         => $request->email,
                'phone'         => $request->phone,
                'address'       => $request->address,
                'delivery_date' => $request->delivery_date,
                'total_amount'  => 0, // will be updated after items
                'status'        => 'pending',
            ]);

            $total = 0;

            // 3.2 Create order items from cart
            foreach ($cart as $item) {
                // Always get fresh price from database – never trust session price
                $product = Product::findOrFail($item['product_id']);
                $price = $product->price;
                $subtotal = $price * $item['quantity'];
                $total += $subtotal;

                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity'   => $item['quantity'],
                    'weight'     => $item['weight'] ?? 1, // default to 1kg if not set
                    'price'      => $price,
                ]);
            }

            // 3.3 Update the order total
            $order->update(['total_amount' => $total]);
        });

        // 4. Clear the cart session
        session()->forget('cart');

        // 5. Redirect to home with success message
        return redirect()->route('home')->with('success', 'Your order has been placed successfully!');
    }
}