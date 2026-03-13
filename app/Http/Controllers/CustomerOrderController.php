<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class CustomerOrderController extends Controller
{
        public function index()
    {
        $orders = Order::where('user_id', auth()->id())
                    ->with(['items' => function ($query) {
                        $query->with(['product' => function ($q) {
                            $q->withTrashed(); // include soft‑deleted products
                        }]);
                    }])
                    ->latest()
                    ->get();

        return view('customer.orders', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::where('user_id', auth()->id())
                    ->with(['items' => function ($query) {
                        $query->with(['product' => function ($q) {
                            $q->withTrashed();
                        }]);
                    }])
                    ->findOrFail($id);
        return view('customer.order-details', compact('order'));
    }


    public function track(Order $order)
    {
        // Ensure the order belongs to the logged-in user
        if ($order->user_id != auth()->id()) {
            abort(403, 'Unauthorized access.');
        }

        return view('order.track', compact('order'));
    }

}