<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        // Current month
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        // Total revenue this month (assuming only paid/delivered orders)
        $revenueThisMonth = Order::whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->where('status', 'delivered')
            ->sum('total_amount');

        // Total customers (users with is_admin = 0, or all users? Let's use all users)
        $totalCustomers = User::count(); // or User::where('is_admin', 0)->count();

        // Pending orders count
        $pendingOrders = Order::where('status', 'pending')->count();

        // Total orders this month
        $ordersThisMonth = Order::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();

        // Sales overview: last 6 months (including current)
        $salesData = Order::select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total_amount) as total')
            )
            ->where('created_at', '>=', Carbon::now()->subMonths(5)->startOfMonth())
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get()
            ->keyBy(function ($item) {
                return $item->year . '-' . str_pad($item->month, 2, '0', STR_PAD_LEFT);
            });

        // Generate labels for last 6 months
        $months = [];
        $values = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $key = $date->format('Y-m');
            $months[] = $date->format('M y'); // e.g., "Sep 25"
            $values[] = isset($salesData[$key]) ? (float) $salesData[$key]->total : 0;
        }

        // Top 5 products by quantity sold (all time)
        $topProducts = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('products.name', 'products.price', 'categories.name as category_name', DB::raw('SUM(order_items.quantity) as total_qty'))
            ->groupBy('products.id', 'products.name', 'products.price', 'categories.name')
            ->orderBy('total_qty', 'desc')
            ->limit(5)
            ->get();

        return view('admin.reports.index', compact(
            'revenueThisMonth',
            'totalCustomers',
            'pendingOrders',
            'ordersThisMonth',
            'months',
            'values',
            'topProducts'
        ));
    }
}