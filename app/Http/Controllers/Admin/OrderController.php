<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use App\Exports\OrdersExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

    /**
     * Dashboard statistics – optimized with single aggregated query.
     */
    public function dashboardStats()
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

        // Recent orders with eager loading to avoid N+1
        $recentOrders = Order::with(['user', 'items.product'])
            ->latest()
            ->limit(5)
            ->get();

        // Top products – single query with join (using OrderItem model)
        $topProducts = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_sold'))
            ->with('product')
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->limit(10)
            ->get();

        // Chart data for last 6 days
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
            'orderStats',
            'activeProducts',
            'recentOrders',
            'topProducts',
            'chartLabels',
            'chartCounts'
        ));
    }

    /**
     * Orders List
     */
    public function index(Request $request)
    {
        $query = Order::with(['user','items.product']);

        // Search (customer, phone, order id)
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('customer_name', 'like', '%' . $request->search . '%')
                ->orWhere('phone', 'like', '%' . $request->search . '%')
                ->orWhere('id', $request->search);
            });
        }

        // Order Source
        if ($request->order_source) {
            $query->where('order_source', $request->order_source);
        }

        // Status
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // Payment Method
        if ($request->payment_method) {
            $query->where('payment_method', $request->payment_method);
        }

        // Delivery Date
        if ($request->delivery_date) {
            $query->whereDate('delivery_date', $request->delivery_date);
        }

        $orders = $query->latest()->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Show Order Details
     */
    public function show(Order $order)
    {
        $order->load('user', 'items.product');

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update Order Status
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|string|in:pending,processing,delivered,cancelled'
        ]);

        $order->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Order status updated successfully.');
    }

    public function exportExcel()
    {
        return Excel::download(new OrdersExport, 'orders_report.xlsx');
    }

    public function exportPDF()
    {
        $orders = Order::with('items')->get();

        $pdf = Pdf::loadView('admin.reports.orders_pdf', compact('orders'));

        return $pdf->download('orders_report.pdf');
    }
}