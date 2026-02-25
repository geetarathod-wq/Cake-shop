<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class CustomerOrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
                    ->with('items.product')
                    ->latest()
                    ->get();

        return view('customer.orders', compact('orders'));
    }
}