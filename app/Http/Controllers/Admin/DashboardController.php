<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Single query for all order counts and revenue
        $orderStats = Order::selectRaw("
            COUNT(*) as total_orders,
            SUM(status = 'pending') as pending_orders,
            SUM(status = 'processing') as processing_orders,
            SUM(status = 'delivered') as delivered_orders,
            SUM(status = 'cancelled') as cancelled_orders,
            SUM(total_amount) as total_revenue
        ")->first();

        // Active products count
        $activeProducts = Product::where('is_active', true)->count();

        // Recent orders with eager loading
        $recentOrders = Order::with(['user', 'items.product'])
            ->latest()
            ->limit(5)
            ->get();

        // Top products (cached for 10 minutes)
        $topProducts = Cache::remember('top_products', 600, function () {
            return OrderItem::select('product_id', DB::raw('SUM(quantity) as total_sold'))
                ->with('product')
                ->groupBy('product_id')
                ->orderByDesc('total_sold')
                ->limit(10)
                ->get();
        });

        // Chart data for last 7 days (cached)
        $chartData = Cache::remember('chart_data', 600, function () {
            return Order::select(
                    DB::raw('DATE(created_at) as date'),
                    DB::raw('COUNT(*) as count')
                )
                ->where('created_at', '>=', now()->subDays(6)->startOfDay())
                ->groupBy('date')
                ->orderBy('date')
                ->get();
        });

        $chartLabels = $chartData->pluck('date')->map(fn($d) => Carbon::parse($d)->format('M d'))->toArray();
        $chartCounts = $chartData->pluck('count')->toArray();

        return view('admin.dashboard', compact(
            'orderStats',
            'activeProducts',
            'recentOrders',
            'topProducts',
            'chartLabels',
            'chartCounts'
        ));
    }
}