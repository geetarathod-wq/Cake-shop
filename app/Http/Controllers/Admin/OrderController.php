<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function dashboardStats()
    {
    $totalOrders   = Order::count();
    $totalRevenue  = Order::sum('total_amount'); // if column is 'total_price', change here
    $totalProducts = Product::count();
    $pendingOrders = Order::where('status', 'pending')->count();
    $recentOrders  = Order::with('items.product')->latest()->take(5)->get();

    return view('admin.dashboard', compact(
        'totalOrders',
        'totalRevenue',
        'totalProducts',
        'pendingOrders',
        'recentOrders'
    ));
    }
    public function index()
    {
        $orders = Order::with('items.product')->latest()->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();
        
        return redirect()->back()->with('success', 'Order status updated.');
    }
}