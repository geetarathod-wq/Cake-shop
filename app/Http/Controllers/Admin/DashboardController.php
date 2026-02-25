<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the Admin Dashboard with real-time stats.
     */
    public function index()
    {
        // 1. Fetch Total Orders count [cite: 7, 182]
        $totalOrders = Order::count();

        // 2. Fetch Pending Orders (Orders awaiting action) [cite: 74, 133]
        $pendingOrders = Order::where('status', 'pending')->count();

        // 3. Calculate Total Revenue from 'paid' or 'delivered' orders [cite: 42, 140]
        $totalRevenue = Order::whereIn('status', ['paid', 'delivered'])->sum('total_amount');

        // 4. Count Active Products in the catalog [cite: 65, 211]
        $totalProducts = Product::where('is_active', true)->count();

        // 5. Fetch 5 Most Recent Orders with eager loading for performance [cite: 90, 158]
        $recentOrders = Order::with(['items.product', 'user'])
            ->latest()
            ->take(5)
            ->get();

        // Pass data to the view located in resources/views/admin/dashboard.blade.php [cite: 338]
        return view('admin.dashboard', compact(
            'totalOrders', 
            'pendingOrders', 
            'totalRevenue', 
            'totalProducts', 
            'recentOrders'
        ));
    }
}