<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WalkInOrderController extends Controller
{
    /**
     * Display all walk-in orders
     */
    public function index()
    {
        $orders = Order::where('order_source', 'walkin')
            ->with('items.product')
            ->latest()
            ->paginate(15);

        return view('admin.walkin-orders.index', compact('orders'));
    }

    /**
     * Show create walk-in order form
     */
    public function create()
    {
        $products = Product::where('is_active', true)->get();

        return view('admin.walkin-orders.create', compact('products'));
    }

    /**
     * Store walk-in order
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'delivery_date' => 'required|date',
            'payment_method' => 'required|in:cash,upi,card',

            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($validated) {

            $subtotal = 0;
            $items = [];

            foreach ($validated['products'] as $item) {

                $product = Product::findOrFail($item['product_id']);

                $price = $product->price;
                $quantity = $item['quantity'];
                $itemSubtotal = $price * $quantity;

                $subtotal += $itemSubtotal;

                $items[] = [
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $price,
                    'subtotal' => $itemSubtotal
                ];
            }

            $order = Order::create([
                'customer_name' => $validated['customer_name'],
                'phone' => $validated['phone'],
                'email' => $validated['email'] ?? null,
                'address' => $validated['address'] ?? null,
                'delivery_date' => $validated['delivery_date'],
                'payment_method' => $validated['payment_method'],
                'status' => 'pending',
                'order_source' => 'walkin',
                'total_amount' => $subtotal
            ]);

            foreach ($items as $item) {
                $order->items()->create($item);
            }

        });

        return redirect()
            ->route('admin.orders.index')
            ->with('success', 'Walk-in order created successfully.');
    }

    /**
     * Show order
     */
    public function show(Order $order)
    {
        $order->load('items.product');

        return view('admin.walkin-orders.show', [
            'walkInOrder' => $order
        ]);
    }
    /**
     * Edit order
     */
    public function edit(Order $order)
    {
        $products = Product::where('is_active', true)->get();

        $order->load('items.product');

        return view('admin.walkin-orders.edit', compact('order', 'products'));
    }

    /**
     * Update order
     */
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'delivery_date' => 'required|date',
            'payment_method' => 'required|in:cash,upi,card',

            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($validated, $order) {

            $subtotal = 0;
            $items = [];

            foreach ($validated['products'] as $item) {

                $product = Product::findOrFail($item['product_id']);

                $price = $product->price;
                $quantity = $item['quantity'];
                $itemSubtotal = $price * $quantity;

                $subtotal += $itemSubtotal;

                $items[] = [
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $price,
                    'subtotal' => $itemSubtotal
                ];
            }

            $order->update([
                'customer_name' => $validated['customer_name'],
                'phone' => $validated['phone'],
                'email' => $validated['email'] ?? null,
                'address' => $validated['address'] ?? null,
                'delivery_date' => $validated['delivery_date'],
                'payment_method' => $validated['payment_method'],
                'total_amount' => $subtotal
            ]);

            $order->items()->delete();

            foreach ($items as $item) {
                $order->items()->create($item);
            }

        });

        return redirect()
            ->route('admin.walkin-orders.index')
            ->with('success', 'Walk-in order updated successfully.');
    }

    /**
     * Delete order
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()
            ->route('admin.walkin-orders.index')
            ->with('success', 'Walk-in order deleted successfully.');
    }
}