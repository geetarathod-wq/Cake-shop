<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use App\Models\WalkInOrder;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrdersExport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Show the report dashboard – now defaults to earliest and latest order dates.
     */
    public function index(Request $request)
    {
        // Get the earliest and latest order dates from the database
        $earliestOrder = Order::min('created_at');
        $latestOrder   = Order::max('created_at');

        // Default start = earliest order date (or 1 year ago if no orders)
        $defaultStart = $earliestOrder ? Carbon::parse($earliestOrder)->toDateString() : now()->subYear()->toDateString();

        // Default end = latest order date (or today if no orders)
        $defaultEnd = $latestOrder ? Carbon::parse($latestOrder)->toDateString() : now()->toDateString();

        // Use user input if provided, otherwise use calculated defaults
        $startDate = $request->input('start_date', $defaultStart);
        $endDate   = $request->input('end_date', $defaultEnd);

        return view('admin.reports.index', compact('startDate', 'endDate'));
    }

    /* ==================== SALES REPORTS ==================== */

    public function dailySales(Request $request)
    {
        try {
            $date = $request->input('date', now()->toDateString());

            $orders = Order::whereDate('created_at', $date)->get();

            $totalOrders   = $orders->count();
            $totalRevenue  = $orders->sum('total_amount');

            $paymentBreakdown = Order::whereDate('created_at', $date)
                ->select('payment_method', DB::raw('COUNT(*) as order_count'), DB::raw('SUM(total_amount) as revenue'))
                ->groupBy('payment_method')
                ->get();

            $ordersByStatus = Order::whereDate('created_at', $date)
                ->select('status', DB::raw('COUNT(*) as count'), DB::raw('SUM(total_amount) as revenue'))
                ->groupBy('status')
                ->get();

            return response()->json([
                'success' => true,
                'report_type' => 'Daily Sales Report',
                'date' => $date,
                'data' => [
                    'summary' => [
                        'total_orders'         => $totalOrders,
                        'total_revenue'        => $totalRevenue,
                        'average_order_value'  => $totalOrders > 0 ? round($totalRevenue / $totalOrders, 2) : 0,
                    ],
                    'payment_breakdown' => $paymentBreakdown,
                    'orders_by_status'  => $ordersByStatus,
                ],
            ]);
        } catch (\Exception $e) {
            Log::error('Daily sales report error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to generate daily sales report.'], 500);
        }
    }

    public function monthlySales(Request $request)
    {
        try {
            $start = $request->input('start_date', now()->startOfMonth()->toDateString());
            $end   = $request->input('end_date', now()->endOfMonth()->toDateString());

            $monthlyData = Order::whereBetween('created_at', [$start, $end])
                ->select(
                    DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                    DB::raw('COUNT(*) as total_orders'),
                    DB::raw('SUM(total_amount) as total_revenue')
                )
                ->groupBy('month')
                ->orderBy('month', 'DESC')
                ->get();

            $latestMonth = $monthlyData->first();
            $previousMonth = $monthlyData->skip(1)->first();

            $growthPercentage = 0;
            if ($latestMonth && $previousMonth && $previousMonth->total_revenue > 0) {
                $growthPercentage = round((($latestMonth->total_revenue - $previousMonth->total_revenue) / $previousMonth->total_revenue) * 100, 2);
            }

            $dailyTrend = [];
            if ($latestMonth) {
                $monthStart = Carbon::parse($latestMonth->month . '-01');
                $monthEnd   = $monthStart->copy()->endOfMonth();
                $dailyTrend = Order::whereBetween('created_at', [$monthStart, $monthEnd])
                    ->select(
                        DB::raw('DATE(created_at) as date'),
                        DB::raw('COUNT(*) as orders'),
                        DB::raw('SUM(total_amount) as revenue')
                    )
                    ->groupBy('date')
                    ->orderBy('date')
                    ->get();
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'current_month' => $latestMonth ?? ['total_orders' => 0, 'total_revenue' => 0, 'average_order' => 0],
                    'growth_percentage' => $growthPercentage,
                    'daily_trend' => $dailyTrend,
                ],
            ]);
        } catch (\Exception $e) {
            Log::error('Monthly sales report error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to generate monthly sales report.'], 500);
        }
    }

    public function productWise(Request $request)
    {
        try {
            $start = $request->input('start_date');
            $end   = $request->input('end_date');

            $products = OrderItem::join('products', 'order_items.product_id', '=', 'products.id')
                ->join('orders', 'order_items.order_id', '=', 'orders.id')
                ->when($start, fn($q) => $q->whereDate('orders.created_at', '>=', $start))
                ->when($end,   fn($q) => $q->whereDate('orders.created_at', '<=', $end))
                ->select(
                    'products.id as product_id',
                    'products.name as product_name',
                    'products.category_id',
                    DB::raw('SUM(order_items.quantity) as quantity_sold'),
                    DB::raw('SUM(order_items.quantity * order_items.price) as revenue'),
                    DB::raw('AVG(order_items.price) as avg_price')
                )
                ->groupBy('products.id', 'products.name', 'products.category_id')
                ->orderByDesc('revenue')
                ->get();

            $products->each(function ($item) {
                $item->category = Category::find($item->category_id)->name ?? 'Uncategorized';
            });

            return response()->json(['success' => true, 'data' => $products]);
        } catch (\Exception $e) {
            Log::error('Product-wise report error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to generate product-wise report.'], 500);
        }
    }

    public function categoryWise(Request $request)
    {
        try {
            $start = $request->input('start_date');
            $end   = $request->input('end_date');

            $categories = Category::leftJoin('products', 'categories.id', '=', 'products.category_id')
                ->leftJoin('order_items', 'products.id', '=', 'order_items.product_id')
                ->leftJoin('orders', 'order_items.order_id', '=', 'orders.id')
                ->when($start, fn($q) => $q->whereDate('orders.created_at', '>=', $start))
                ->when($end,   fn($q) => $q->whereDate('orders.created_at', '<=', $end))
                ->select(
                    'categories.id as category_id',
                    'categories.name as category_name',
                    DB::raw('COUNT(DISTINCT products.id) as product_count'),
                    DB::raw('COALESCE(SUM(order_items.quantity), 0) as total_quantity'),
                    DB::raw('COALESCE(SUM(order_items.quantity * order_items.price), 0) as total_revenue')
                )
                ->groupBy('categories.id', 'categories.name')
                ->orderByDesc('total_revenue')
                ->get();

            return response()->json(['success' => true, 'data' => $categories]);
        } catch (\Exception $e) {
            Log::error('Category-wise report error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to generate category-wise report.'], 500);
        }
    }

    public function topProducts(Request $request)
    {
        try {
            $start = $request->input('start_date');
            $end   = $request->input('end_date');

            $products = OrderItem::join('products', 'order_items.product_id', '=', 'products.id')
                ->join('orders', 'order_items.order_id', '=', 'orders.id')
                ->when($start, fn($q) => $q->whereDate('orders.created_at', '>=', $start))
                ->when($end,   fn($q) => $q->whereDate('orders.created_at', '<=', $end))
                ->select(
                    'products.id',
                    'products.name as product_name',
                    'products.category_id',
                    DB::raw('SUM(order_items.quantity) as quantity_sold'),
                    DB::raw('SUM(order_items.quantity * order_items.price) as revenue')
                )
                ->groupBy('products.id', 'products.name', 'products.category_id')
                ->orderByDesc('quantity_sold')
                ->limit(10)
                ->get()
                ->map(function ($item, $index) {
                    $item->rank = $index + 1;
                    $item->category = Category::find($item->category_id)->name ?? 'Uncategorized';
                    return $item;
                });

            return response()->json(['success' => true, 'data' => $products]);
        } catch (\Exception $e) {
            Log::error('Top products report error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to generate top products report.'], 500);
        }
    }

    public function lowProducts(Request $request)
    {
        try {
            $start = $request->input('start_date');
            $end   = $request->input('end_date');

            $products = Product::leftJoin('order_items', 'products.id', '=', 'order_items.product_id')
                ->leftJoin('orders', 'order_items.order_id', '=', 'orders.id')
                ->when($start, fn($q) => $q->whereDate('orders.created_at', '>=', $start))
                ->when($end,   fn($q) => $q->whereDate('orders.created_at', '<=', $end))
                ->select(
                    'products.id',
                    'products.name as product_name',
                    'products.category_id',
                    'products.price',
                    DB::raw('COALESCE(SUM(order_items.quantity), 0) as quantity_sold')
                )
                ->groupBy('products.id', 'products.name', 'products.category_id', 'products.price')
                ->orderBy('quantity_sold', 'asc')
                ->get()
                ->map(function ($item) {
                    $item->category = Category::find($item->category_id)->name ?? 'Uncategorized';
                    $item->status = $item->quantity_sold == 0 ? 'No Sales' : 'Low';
                    return $item;
                });

            return response()->json(['success' => true, 'data' => $products]);
        } catch (\Exception $e) {
            Log::error('Low products report error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to generate low products report.'], 500);
        }
    }

    /* ==================== ORDER & OPERATIONS ==================== */

    public function orderSummary(Request $request)
    {
        try {
            $start = $request->input('start_date');
            $end   = $request->input('end_date');

            $summary = Order::when($start, fn($q) => $q->whereDate('created_at', '>=', $start))
                ->when($end, fn($q) => $q->whereDate('created_at', '<=', $end))
                ->select(
                    'status',
                    DB::raw('COUNT(*) as order_count'),
                    DB::raw('SUM(total_amount) as total_value')
                )
                ->groupBy('status')
                ->get();

            $totalOrders = $summary->sum('order_count');
            $totalValue  = $summary->sum('total_value');

            return response()->json([
                'success' => true,
                'data' => [
                    'summary' => [
                        'total_orders' => $totalOrders,
                        'total_value'  => $totalValue,
                    ],
                    'data' => $summary,
                ],
            ]);
        } catch (\Exception $e) {
            Log::error('Order summary error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to generate order summary.'], 500);
        }
    }

    public function customCakes(Request $request)
    {
        try {
            $start = $request->input('start_date');
            $end   = $request->input('end_date');

            $orders = Order::where('order_type', 'custom')
                ->when($start, fn($q) => $q->whereDate('created_at', '>=', $start))
                ->when($end,   fn($q) => $q->whereDate('created_at', '<=', $end))
                ->with('items.product')
                ->get()
                ->map(function ($order) {
                    return [
                        'order_number'        => $order->id,
                        'customer_name'       => $order->name,
                        'cake_message'        => $order->custom_message ?? null,
                        'special_instructions'=> $order->special_instructions ?? null,
                        'total_amount'        => $order->total_amount,
                        'status'              => $order->status,
                    ];
                });

            return response()->json(['success' => true, 'data' => $orders]);
        } catch (\Exception $e) {
            Log::error('Custom cakes report error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to generate custom cakes report.'], 500);
        }
    }

    public function orderTypeComparison(Request $request)
    {
        try {
            $start = $request->input('start_date');
            $end   = $request->input('end_date');

            $data = Order::when($start, fn($q) => $q->whereDate('created_at', '>=', $start))
                ->when($end,   fn($q) => $q->whereDate('created_at', '<=', $end))
                ->select(
                    'order_type',
                    DB::raw('COUNT(*) as count'),
                    DB::raw('SUM(total_amount) as revenue')
                )
                ->groupBy('order_type')
                ->get();

            $preOrders = $data->firstWhere('order_type', 'preorder') ?? ['count' => 0, 'revenue' => 0];
            $walkIn    = $data->firstWhere('order_type', 'walkin') ?? ['count' => 0, 'revenue' => 0];

            return response()->json([
                'success' => true,
                'data' => [
                    'pre_orders' => [
                        'count'   => $preOrders['count'],
                        'revenue' => $preOrders['revenue'],
                        'average' => $preOrders['count'] > 0 ? round($preOrders['revenue'] / $preOrders['count'], 2) : 0,
                    ],
                    'walk_in' => [
                        'count'   => $walkIn['count'],
                        'revenue' => $walkIn['revenue'],
                        'average' => $walkIn['count'] > 0 ? round($walkIn['revenue'] / $walkIn['count'], 2) : 0,
                    ],
                ],
            ]);
        } catch (\Exception $e) {
            Log::error('Order type comparison error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to generate order type report.'], 500);
        }
    }

    public function deliveryPickup(Request $request)
    {
        try {
            $start = $request->input('start_date');
            $end   = $request->input('end_date');

            $data = Order::when($start, fn($q) => $q->whereDate('created_at', '>=', $start))
                ->when($end,   fn($q) => $q->whereDate('created_at', '<=', $end))
                ->select(
                    'order_type',
                    DB::raw('COUNT(*) as count')
                )
                ->whereIn('order_type', ['delivery', 'pickup'])
                ->groupBy('order_type')
                ->get();

            $delivery = $data->firstWhere('order_type', 'delivery')['count'] ?? 0;
            $pickup   = $data->firstWhere('order_type', 'pickup')['count'] ?? 0;

            return response()->json([
                'success' => true,
                'data' => [
                    ['type' => 'delivery', 'orders' => $delivery],
                    ['type' => 'pickup',   'orders' => $pickup],
                ],
            ]);
        } catch (\Exception $e) {
            Log::error('Delivery vs pickup report error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to generate delivery vs pickup report.'], 500);
        }
    }

    public function deliveryOrders(Request $request)
    {
        try {
            $start = $request->input('start_date');
            $end   = $request->input('end_date');

            // Check required columns exist
            $hasAddress = Schema::hasColumn('orders', 'address');
            $hasDeliveryDate = Schema::hasColumn('orders', 'delivery_date');
            $hasDeliverySlot = Schema::hasColumn('orders', 'delivery_slot');

            // Build select list dynamically
            $select = ['id', 'name', 'status', 'total_amount'];
            if ($hasAddress) $select[] = 'address';
            if ($hasDeliveryDate) $select[] = 'delivery_date';
            if ($hasDeliverySlot) $select[] = 'delivery_slot';

            $orders = Order::where('order_type', 'delivery')
                ->when($start, fn($q) => $q->whereDate('created_at', '>=', $start))
                ->when($end,   fn($q) => $q->whereDate('created_at', '<=', $end))
                ->select($select)
                ->get();

            // Map to ensure all expected fields exist (fill missing with empty strings)
            $orders = $orders->map(function ($order) use ($hasAddress, $hasDeliveryDate, $hasDeliverySlot) {
                return [
                    'id'             => $order->id,
                    'name'           => $order->name ?? '',
                    'address'        => $hasAddress ? ($order->address ?? '') : 'N/A',
                    'delivery_date'  => $hasDeliveryDate ? ($order->delivery_date ?? '') : 'N/A',
                    'delivery_slot'  => $hasDeliverySlot ? ($order->delivery_slot ?? '') : 'N/A',
                    'status'         => $order->status ?? '',
                    'total_amount'   => $order->total_amount ?? 0,
                ];
            });

            return response()->json(['success' => true, 'data' => $orders]);
        } catch (\Exception $e) {
            Log::error('Delivery orders report error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to generate delivery orders report. Required columns may be missing.'], 500);
        }
    }

    public function pickupOrders(Request $request)
    {
        try {
            $start = $request->input('start_date');
            $end   = $request->input('end_date');

            // Check required columns exist
            $hasPickupDate = Schema::hasColumn('orders', 'pickup_date');
            $hasPickupSlot = Schema::hasColumn('orders', 'pickup_slot');

            // Build select list dynamically
            $select = ['id', 'name', 'status', 'total_amount'];
            if ($hasPickupDate) $select[] = 'pickup_date';
            if ($hasPickupSlot) $select[] = 'pickup_slot';

            $orders = Order::where('order_type', 'pickup')
                ->when($start, fn($q) => $q->whereDate('created_at', '>=', $start))
                ->when($end,   fn($q) => $q->whereDate('created_at', '<=', $end))
                ->select($select)
                ->get();

            // Map to ensure all expected fields exist
            $orders = $orders->map(function ($order) use ($hasPickupDate, $hasPickupSlot) {
                return [
                    'id'           => $order->id,
                    'name'         => $order->name ?? '',
                    'pickup_date'  => $hasPickupDate ? ($order->pickup_date ?? '') : 'N/A',
                    'pickup_slot'  => $hasPickupSlot ? ($order->pickup_slot ?? '') : 'N/A',
                    'status'       => $order->status ?? '',
                    'total_amount' => $order->total_amount ?? 0,
                ];
            });

            return response()->json(['success' => true, 'data' => $orders]);
        } catch (\Exception $e) {
            Log::error('Pickup orders report error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to generate pickup orders report. Required columns may be missing.'], 500);
        }
    }

    /* ==================== CUSTOMER REPORTS ==================== */

    public function topCustomers(Request $request)
    {
        try {
            $start = $request->input('start_date');
            $end   = $request->input('end_date');

            // Check if the 'orders' relationship exists on User model
            if (!method_exists(User::class, 'orders')) {
                // Fallback: query orders table directly, join with users
                $customers = DB::table('users')
                    ->leftJoin('orders', 'users.id', '=', 'orders.user_id')
                    ->when($start, fn($q) => $q->whereDate('orders.created_at', '>=', $start))
                    ->when($end,   fn($q) => $q->whereDate('orders.created_at', '<=', $end))
                    ->select(
                        'users.id',
                        'users.name',
                        'users.email',
                        DB::raw('COUNT(orders.id) as total_orders'),
                        DB::raw('COALESCE(SUM(orders.total_amount), 0) as total_spent')
                    )
                    ->groupBy('users.id', 'users.name', 'users.email')
                    ->orderByDesc('total_spent')
                    ->limit(10)
                    ->get()
                    ->map(function ($customer, $index) {
                        return [
                            'rank'          => $index + 1,
                            'name'          => $customer->name,
                            'email'         => $customer->email,
                            'total_orders'  => $customer->total_orders,
                            'total_spent'   => $customer->total_spent,
                            'average_order' => $customer->total_orders > 0 ? round($customer->total_spent / $customer->total_orders, 2) : 0,
                        ];
                    });

                return response()->json(['success' => true, 'data' => $customers]);
            }

            // Original logic using relationship
            $customers = User::withCount(['orders' => function ($q) use ($start, $end) {
                    if ($start) $q->whereDate('created_at', '>=', $start);
                    if ($end)   $q->whereDate('created_at', '<=', $end);
                }])
                ->withSum(['orders' => function ($q) use ($start, $end) {
                    if ($start) $q->whereDate('created_at', '>=', $start);
                    if ($end)   $q->whereDate('created_at', '<=', $end);
                }], 'total_amount')
                ->orderByDesc('orders_sum_total_amount')
                ->limit(10)
                ->get()
                ->map(function ($customer, $index) {
                    return [
                        'rank'           => $index + 1,
                        'name'           => $customer->name,
                        'email'          => $customer->email,
                        'total_orders'   => $customer->orders_count,
                        'total_spent'    => $customer->orders_sum_total_amount ?? 0,
                        'average_order'  => $customer->orders_count > 0 ? round(($customer->orders_sum_total_amount ?? 0) / $customer->orders_count, 2) : 0,
                    ];
                });

            return response()->json(['success' => true, 'data' => $customers]);
        } catch (\Exception $e) {
            Log::error('Top customers report error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to generate top customers report.'], 500);
        }
    }

    public function customerHistory(Request $request, $customer = null)
    {
        try {
            $customerId = $customer ?? $request->input('customer_id');
            if (!$customerId) {
                return response()->json(['success' => false, 'message' => 'Please select a customer to view history.'], 400);
            }

            $customer = User::find($customerId);
            if (!$customer) {
                return response()->json(['success' => false, 'message' => 'Customer not found.'], 404);
            }

            // Check if orders relationship exists
            if (!method_exists($customer, 'orders')) {
                // Fallback: query orders table directly
                $ordersData = Order::where('user_id', $customerId)
                    ->with('items.product')
                    ->orderByDesc('created_at')
                    ->get();
            } else {
                $ordersData = $customer->orders()
                    ->with('items.product')
                    ->orderByDesc('created_at')
                    ->get();
            }

            $orders = $ordersData->map(function ($order) {
                return [
                    'order_number'   => $order->id,
                    'date'           => $order->created_at->format('Y-m-d'),
                    'total'          => $order->total_amount,
                    'status'         => $order->status,
                    'payment_method' => $order->payment_method,
                ];
            });

            $summary = [
                'total_orders'   => $orders->count(),
                'total_spent'    => $orders->sum('total'),
                'average_order'  => $orders->count() > 0 ? round($orders->sum('total') / $orders->count(), 2) : 0,
            ];

            // Check if phone column exists
            $phone = '';
            if (Schema::hasColumn('users', 'phone')) {
                $phone = $customer->phone ?? '';
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'customer' => [
                        'name'         => $customer->name,
                        'email'        => $customer->email,
                        'phone'        => $phone,
                        'member_since' => $customer->created_at->format('Y-m-d'),
                    ],
                    'summary' => $summary,
                    'orders'  => $orders,
                ],
            ]);
        } catch (\Exception $e) {
            Log::error('Customer history report error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to generate customer history.'], 500);
        }
    }

    public function newReturning(Request $request)
    {
        try {
            $start = $request->input('start_date');
            $end   = $request->input('end_date');

            $orders = Order::when($start, fn($q) => $q->whereDate('created_at', '>=', $start))
                ->when($end,   fn($q) => $q->whereDate('created_at', '<=', $end))
                ->select('user_id', 'created_at', 'total_amount')
                ->get();

            $userOrders = $orders->groupBy('user_id');

            $newCount = 0;
            $newRevenue = 0;
            $returningCount = 0;
            $returningRevenue = 0;

            foreach ($userOrders as $userId => $userOrderCollection) {
                if ($userId === null) continue;
                $firstOrderDate = $userOrderCollection->min('created_at');
                $isNew = $firstOrderDate->between($start, $end);
                if ($isNew) {
                    $newCount++;
                    $newRevenue += $userOrderCollection->sum('total_amount');
                } else {
                    $returningCount++;
                    $returningRevenue += $userOrderCollection->sum('total_amount');
                }
            }

            $totalCustomers = $newCount + $returningCount;
            $totalRevenue   = $newRevenue + $returningRevenue;

            return response()->json([
                'success' => true,
                'data' => [
                    'new' => [
                        'customer_count' => $newCount,
                        'revenue'        => $newRevenue,
                        'percentage'     => $totalCustomers > 0 ? round(($newCount / $totalCustomers) * 100, 2) : 0,
                    ],
                    'returning' => [
                        'customer_count' => $returningCount,
                        'revenue'        => $returningRevenue,
                        'percentage'     => $totalCustomers > 0 ? round(($returningCount / $totalCustomers) * 100, 2) : 0,
                    ],
                ],
            ]);
        } catch (\Exception $e) {
            Log::error('New vs returning report error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to generate new vs returning report.'], 500);
        }
    }

    public function customerFrequency(Request $request)
    {
        try {
            $start = $request->input('start_date');
            $end   = $request->input('end_date');

            $orders = Order::when($start, fn($q) => $q->whereDate('created_at', '>=', $start))
                ->when($end,   fn($q) => $q->whereDate('created_at', '<=', $end))
                ->select('user_id', 'created_at')
                ->get()
                ->groupBy('user_id');

            $weekly    = 0;
            $monthly   = 0;
            $quarterly = 0;
            $yearly    = 0;
            $oneTime   = 0;

            foreach ($orders as $userId => $userOrders) {
                $count = $userOrders->count();
                if ($count == 1) {
                    $oneTime++;
                } else {
                    $first = $userOrders->min('created_at');
                    $last  = $userOrders->max('created_at');
                    $days  = $first->diffInDays($last);
                    if ($days <= 7) {
                        $weekly++;
                    } elseif ($days <= 30) {
                        $monthly++;
                    } elseif ($days <= 90) {
                        $quarterly++;
                    } else {
                        $yearly++;
                    }
                }
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'weekly'    => $weekly,
                    'monthly'   => $monthly,
                    'quarterly' => $quarterly,
                    'yearly'    => $yearly,
                    'one_time'  => $oneTime,
                ],
            ]);
        } catch (\Exception $e) {
            Log::error('Customer frequency report error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to generate customer frequency report.'], 500);
        }
    }

    /* ==================== INVENTORY REPORTS ==================== */

    public function inventoryUsage(Request $request)
    {
        // Placeholder – replace with actual inventory logic if tables exist
        return response()->json([
            'success' => true,
            'data' => [
                ['name' => 'Flour', 'used' => 0],
                ['name' => 'Sugar', 'used' => 0],
                ['name' => 'Cream', 'used' => 0],
                ['name' => 'Chocolate', 'used' => 0],
                ['name' => 'Butter', 'used' => 0],
                ['name' => 'Eggs', 'used' => 0],
            ],
        ]);
    }

    public function lowStock(Request $request)
    {
        return response()->json(['success' => true, 'data' => []]);
    }

    public function stockMovement(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => [
                ['name' => 'Flour', 'added' => 0, 'used' => 0, 'waste' => 0],
                ['name' => 'Sugar', 'added' => 0, 'used' => 0, 'waste' => 0],
            ],
        ]);
    }

    /* ==================== FINANCIAL REPORTS ==================== */

    public function profitMargin(Request $request)
    {
        try {
            $start = $request->input('start_date');
            $end   = $request->input('end_date');

            // If cost_price column doesn't exist, return empty data with message
            if (!Schema::hasColumn('products', 'cost_price')) {
                return response()->json([
                    'success' => true,
                    'data' => [],
                    'message' => 'Cost price data not available in products table.'
                ]);
            }

            $products = OrderItem::join('products', 'order_items.product_id', '=', 'products.id')
                ->join('orders', 'order_items.order_id', '=', 'orders.id')
                ->when($start, fn($q) => $q->whereDate('orders.created_at', '>=', $start))
                ->when($end,   fn($q) => $q->whereDate('orders.created_at', '<=', $end))
                ->select(
                    'products.id',
                    'products.name as product_name',
                    'products.price',
                    'products.cost_price',
                    DB::raw('SUM(order_items.quantity) as quantity'),
                    DB::raw('SUM(order_items.quantity * order_items.price) as revenue'),
                    DB::raw('SUM(order_items.quantity * COALESCE(products.cost_price, 0)) as cost_total')
                )
                ->groupBy('products.id', 'products.name', 'products.price', 'products.cost_price')
                ->get()
                ->map(function ($item) {
                    $item->profit = $item->revenue - $item->cost_total;
                    $item->margin = $item->revenue > 0 ? round(($item->profit / $item->revenue) * 100, 2) : 0;
                    return $item;
                });

            return response()->json(['success' => true, 'data' => $products]);
        } catch (\Exception $e) {
            Log::error('Profit margin report error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to generate profit margin report.'], 500);
        }
    }

    public function discountReport(Request $request)
    {
        try {
            $start = $request->input('start_date');
            $end   = $request->input('end_date');

            $orders = Order::when($start, fn($q) => $q->whereDate('created_at', '>=', $start))
                ->when($end,   fn($q) => $q->whereDate('created_at', '<=', $end))
                ->select('id', 'discount_amount', 'total_amount')
                ->get();

            $totalOrders         = $orders->count();
            $discountedOrders    = $orders->where('discount_amount', '>', 0)->count();
            $totalDiscountGiven  = $orders->sum('discount_amount');
            $totalRevenue        = $orders->sum('total_amount');
            $averageDiscount     = $discountedOrders > 0 ? round($totalDiscountGiven / $discountedOrders, 2) : 0;
            $revenueImpact       = $totalRevenue > 0 ? round(($totalDiscountGiven / ($totalRevenue + $totalDiscountGiven)) * 100, 2) : 0;

            return response()->json([
                'success' => true,
                'data' => [
                    'total_orders'          => $totalOrders,
                    'discounted_orders'     => $discountedOrders,
                    'total_discount_given'  => $totalDiscountGiven,
                    'average_discount'      => $averageDiscount,
                    'revenue_impact'        => $revenueImpact,
                ],
            ]);
        } catch (\Exception $e) {
            Log::error('Discount report error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to generate discount report.'], 500);
        }
    }

    public function paymentMethods(Request $request)
    {
        try {
            $start = $request->input('start_date');
            $end   = $request->input('end_date');

            $data = Order::when($start, fn($q) => $q->whereDate('created_at', '>=', $start))
                ->when($end,   fn($q) => $q->whereDate('created_at', '<=', $end))
                ->select(
                    'payment_method',
                    DB::raw('COUNT(*) as order_count'),
                    DB::raw('SUM(total_amount) as revenue')
                )
                ->groupBy('payment_method')
                ->get();

            $totalRevenue = $data->sum('revenue');
            $data->each(function ($item) use ($totalRevenue) {
                $item->percentage = $totalRevenue > 0 ? round(($item->revenue / $totalRevenue) * 100, 2) : 0;
            });

            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            Log::error('Payment methods report error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to generate payment methods report.'], 500);
        }
    }

    /* ==================== WALK-IN CUSTOMERS ==================== */

    public function walkinCustomers(Request $request)
    {
        try {
            $orders = WalkInOrder::with(['items.product'])
                ->orderBy('created_at', 'DESC')
                ->paginate(20);

            return view('admin.reports.walkin-customers', compact('orders'));
        } catch (\Exception $e) {
            Log::error('Walk-in customers view error: ' . $e->getMessage());
            abort(500, 'Failed to load walk-in customers.');
        }
    }

    /* ==================== EXPORTS ==================== */

    public function exportPDF(Request $request)
    {
        try {
            $start = $request->input('start_date');
            $end   = $request->input('end_date');

            $orders = Order::when($start, fn($q) => $q->whereDate('created_at', '>=', $start))
                ->when($end,   fn($q) => $q->whereDate('created_at', '<=', $end))
                ->latest()
                ->get();

            $pdf = Pdf::loadView('admin.reports.orders_pdf', compact('orders'));
            return $pdf->download('orders_report.pdf');
        } catch (\Exception $e) {
            Log::error('PDF export error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to export PDF.'], 500);
        }
    }

    public function exportExcel(Request $request)
    {
        try {
            $start = $request->input('start_date');
            $end   = $request->input('end_date');

            return Excel::download(new OrdersExport($start, $end), 'orders_report.xlsx');
        } catch (\Exception $e) {
            Log::error('Excel export error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to export Excel.'], 500);
        }
    }
}