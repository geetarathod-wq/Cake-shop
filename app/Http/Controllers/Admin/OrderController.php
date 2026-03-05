<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function dashboardStats()
    {
        $totalOrders   = Order::count();
        $totalRevenue  = Order::sum('total_amount');
        $totalProducts = Product::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $recentOrders  = Order::with('items.product')->latest()->take(5)->get();

        // Additional status counts
        $processingOrders = Order::where('status', 'processing')->count();
        $deliveredOrders  = Order::where('status', 'delivered')->count();
        $cancelledOrders  = Order::where('status', 'cancelled')->count();

        // Top 5 products by quantity sold
        $topProducts = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->select('products.name', DB::raw('SUM(order_items.quantity) as total_qty'))
            ->groupBy('products.id', 'products.name')
            ->orderBy('total_qty', 'desc')
            ->limit(5)
            ->get();

        // Chart data: orders per day for last 7 days
        $chartData = Order::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('count(*) as count')
            )
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $chartLabels = $chartData->pluck('date')->map(function($date) {
            return \Carbon\Carbon::parse($date)->format('M d');
        })->toArray();
        $chartCounts = $chartData->pluck('count')->toArray();

        return view('admin.dashboard', compact(
            'totalOrders',
            'totalRevenue',
            'totalProducts',
            'pendingOrders',
            'recentOrders',
            'chartLabels',
            'chartCounts',
            'processingOrders',
            'deliveredOrders',
            'cancelledOrders',
            'topProducts'
        ));
    }

    public function index()
    {
        $orders = Order::with('items.product')->latest()->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function update(Request $request, $id)
    {
        // Validate the status input
        $request->validate([
            'status' => 'required|in:pending,processing,delivered,cancelled',
        ]);

        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();
        
        return redirect()->back()->with('success', 'Order status updated.');
    }
}