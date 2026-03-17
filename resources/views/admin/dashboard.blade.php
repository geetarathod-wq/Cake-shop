@extends('admin.layouts.app')

@section('title', 'Dashboard Overview')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Welcome Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 fw-bold" style="color: var(--gold);">Dashboard Overview</h1>
            <p class="text-muted">Welcome back, {{ auth()->user()->name }} <span class="badge bg-gold text-dark">Administrator</span></p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <!-- Total Orders -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted small mb-1">TOTAL ORDERS</p>
                            <h2 class="fw-bold mb-0">{{ number_format($orderStats->total_orders) }}</h2>
                        </div>
                        <div class="bg-soft-gold rounded-circle p-3">
                            <i class="fas fa-shopping-bag fa-2x" style="color: var(--gold);"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Orders -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted small mb-1">PENDING ORDERS</p>
                            <h2 class="fw-bold mb-0">{{ number_format($orderStats->pending_orders) }}</h2>
                        </div>
                        <div class="bg-soft-warning rounded-circle p-3">
                            <i class="fas fa-clock fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Revenue -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted small mb-1">TOTAL REVENUE</p>
                            <h2 class="fw-bold mb-0" style="font-size: calc(1.2rem + 0.3vw);">
                                {{-- Use formatCurrency($orderStats->total_revenue) if you want abbreviation --}}
                                ₹{{ number_format($orderStats->total_revenue, 2) }}
                            </h2>
                        </div>
                        <div class="bg-soft-success rounded-circle p-3">
                            <i class="fas fa-coins fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Products -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted small mb-1">ACTIVE PRODUCTS</p>
                            <h2 class="fw-bold mb-0">{{ number_format($activeProducts) }}</h2>
                        </div>
                        <div class="bg-soft-info rounded-circle p-3">
                            <i class="fas fa-cake-candles fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Status Summary -->
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="fw-bold mb-0">Order Status</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-3">
                            <div class="bg-soft-warning p-3 rounded">
                                <h6 class="fw-bold">Pending</h6>
                                <p class="fs-4">{{ number_format($orderStats->pending_orders) }}</p>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="bg-soft-info p-3 rounded">
                                <h6 class="fw-bold">Processing</h6>
                                <p class="fs-4">{{ number_format($orderStats->processing_orders) }}</p>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="bg-soft-success p-3 rounded">
                                <h6 class="fw-bold">Delivered</h6>
                                <p class="fs-4">{{ number_format($orderStats->delivered_orders) }}</p>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="bg-soft-danger p-3 rounded">
                                <h6 class="fw-bold">Cancelled</h6>
                                <p class="fs-4">{{ number_format($orderStats->cancelled_orders) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="fw-bold mb-0">Orders Trend (Last 7 Days)</h5>
                </div>
                <div class="card-body">
                    <canvas id="ordersChart" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0">
            <h5 class="fw-bold mb-0">Recent Orders</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Items</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th class="text-end">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->user->name ?? $order->customer_name }}</td>
                            <td>{{ $order->items->count() }} item(s)</td>
                            <td>{{ $order->created_at->format('d M, Y') }}</td>
                            <td>
                                <span class="badge bg-{{ $order->status === 'pending' ? 'warning' : ($order->status === 'processing' ? 'info' : ($order->status === 'delivered' ? 'success' : 'danger')) }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="text-end fw-bold">₹{{ number_format($order->total_amount, 2) }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center">No recent orders</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Top Products -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0">
            <h5 class="fw-bold mb-0">Top Products</h5>
        </div>
        <div class="card-body">
            <div class="row g-4">
                @foreach($topProducts as $index => $item)
                <div class="col-md-6">
                    <div class="d-flex align-items-center">
                        <span class="badge bg-gold me-3 rounded-circle p-3" style="width: 40px; height: 40px;">#{{ $index + 1 }}</span>
                        <div>
                            <h6 class="mb-1">{{ $item->product->name ?? 'Unknown' }}</h6>
                            <p class="text-muted mb-0">{{ $item->total_sold }} sold</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('ordersChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartLabels) !!},
            datasets: [{
                label: 'Orders',
                data: {!! json_encode($chartCounts) !!},
                borderColor: 'rgb(255, 215, 0)',
                backgroundColor: 'rgba(255, 215, 0, 0.1)',
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            }
        }
    });
});
</script>
@endpush

@push('styles')
<style>
    .stat-card { transition: transform 0.3s; }
    .stat-card:hover { transform: translateY(-5px); }
    .bg-soft-gold { background-color: rgba(255, 215, 0, 0.1); }
    .bg-soft-warning { background-color: rgba(255, 193, 7, 0.1); }
    .bg-soft-success { background-color: rgba(40, 167, 69, 0.1); }
    .bg-soft-info { background-color: rgba(23, 162, 184, 0.1); }
    .bg-soft-danger { background-color: rgba(220, 53, 69, 0.1); }
    .bg-gold { background-color: var(--gold); color: var(--dark); }
</style>
@endpush