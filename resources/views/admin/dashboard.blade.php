@extends('admin.layouts.app')

@section('title', 'Dashboard - Blonde Bakery Admin')

@section('content')
<div class="container-fluid px-4 py-4">

    <!-- Welcome Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 fw-bold" style="background: linear-gradient(135deg, var(--dark), var(--gold)); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                Dashboard Overview
            </h1>
            <p class="text-muted">
                Welcome back, <strong>{{ Auth::user()->name ?? 'Admin' }}</strong>
                <span class="badge bg-gold-light text-dark ms-2">Administrator</span>
            </p>
        </div>
        <a href="{{ route('home') }}" class="btn btn-gold" target="_blank">
            <i class="fas fa-eye me-2"></i>View Site
        </a>
    </div>

    <!-- Stats Cards (glassmorphism style) -->
    <div class="row g-4 mb-5">
        <div class="col-xl-3 col-md-6">
            <div class="card glass-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="icon-box bg-primary bg-opacity-10 text-primary">
                            <i class="fas fa-box"></i>
                        </div>
                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill">+12.3%</span>
                    </div>
                    <h3 class="fw-bold mb-1">{{ $totalOrders ?? 0 }}</h3>
                    <p class="text-muted mb-2">Total Orders</p>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-primary" style="width: 78%"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card glass-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="icon-box bg-warning bg-opacity-10 text-warning">
                            <i class="fas fa-clock"></i>
                        </div>
                        <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill">▲ 4</span>
                    </div>
                    <h3 class="fw-bold mb-1">{{ $pendingOrders ?? 0 }}</h3>
                    <p class="text-muted mb-2">Pending Orders</p>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-warning" style="width: 35%"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card glass-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="icon-box bg-success bg-opacity-10 text-success">
                            <i class="fas fa-indian-rupee-sign"></i>
                        </div>
                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill">+5.2%</span>
                    </div>
                    <h3 class="fw-bold mb-1">₹{{ number_format($totalRevenue ?? 0, 2) }}</h3>
                    <p class="text-muted mb-2">Revenue</p>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-success" style="width: 82%"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card glass-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="icon-box bg-danger bg-opacity-10 text-danger">
                            <i class="fas fa-cake-candles"></i>
                        </div>
                        <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill">0</span>
                    </div>
                    <h3 class="fw-bold mb-1">{{ $totalProducts ?? 0 }}</h3>
                    <p class="text-muted mb-2">Active Products</p>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-danger" style="width: 60%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-4 mb-5">
        <div class="col-xl-8">
            <div class="card modern-card">
                <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">Revenue Trend</h5>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            Last 7 days
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Last 7 days</a></li>
                            <li><a class="dropdown-item" href="#">This month</a></li>
                            <li><a class="dropdown-item" href="#">Last month</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="revenueChart" style="height: 300px;"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card modern-card h-100">
                <div class="card-header bg-transparent border-0">
                    <h5 class="fw-bold mb-0">Order Status</h5>
                </div>
                <div class="card-body d-flex flex-column justify-content-center">
                    <canvas id="statusChart" style="height: 200px;"></canvas>
                    <div class="mt-3">
                        <div class="d-flex justify-content-between small">
                            <span><span class="badge bg-warning me-2">&nbsp;</span> Pending</span>
                            <span class="fw-bold">{{ $pendingOrders ?? 0 }}</span>
                        </div>
                        <div class="d-flex justify-content-between small mt-1">
                            <span><span class="badge bg-success me-2">&nbsp;</span> Delivered</span>
                            <span class="fw-bold">{{ $deliveredOrders ?? 0 }}</span>
                        </div>
                        <div class="d-flex justify-content-between small mt-1">
                            <span><span class="badge bg-info me-2">&nbsp;</span> Processing</span>
                            <span class="fw-bold">{{ $processingOrders ?? 0 }}</span>
                        </div>
                        <div class="d-flex justify-content-between small mt-1">
                            <span><span class="badge bg-secondary me-2">&nbsp;</span> Cancelled</span>
                            <span class="fw-bold">{{ $cancelledOrders ?? 0 }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders & Top Products -->
    <div class="row g-4 mb-5">
        <div class="col-xl-7">
            <div class="card modern-card">
                <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">Recent Orders</h5>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-gold">View All</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
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
                                @forelse($recentOrders ?? [] as $order)
                                <tr>
                                    <td class="fw-medium">#{{ $order->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-circle me-2">
                                                <span class="initial">{{ substr($order->name ?? 'G', 0, 1) }}</span>
                                            </div>
                                            <span>{{ $order->name ?? $order->user->name ?? 'Guest' }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        @if($order->items->count() > 0)
                                            {{ $order->items->count() }} item(s)
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td>{{ $order->created_at->format('d M, Y') }}</td>
                                    <td>
                                        @php
                                            $statusClass = match($order->status) {
                                                'delivered' => 'success',
                                                'pending'   => 'warning',
                                                'processing'=> 'info',
                                                'cancelled' => 'danger',
                                                default     => 'secondary'
                                            };
                                        @endphp
                                        <span class="badge bg-{{ $statusClass }} bg-opacity-10 text-{{ $statusClass }} px-3 py-2 rounded-pill">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td class="text-end fw-bold">₹{{ number_format($order->total_amount, 2) }}</td>
                                </tr>
                                @empty
                                <tr><td colspan="6" class="text-center py-4">No recent orders</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-5">
            <div class="card modern-card">
                <div class="card-header bg-transparent border-0">
                    <h5 class="fw-bold mb-0">Top Products</h5>
                </div>
                <div class="card-body">
                    @forelse($topProducts ?? [] as $index => $product)
                    <div class="d-flex align-items-center mb-3">
                        <span class="badge bg-gold-light text-dark rounded-circle me-2" style="width: 24px; height: 24px; display: flex; align-items: center; justify-content: center;">{{ $index + 1 }}</span>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between">
                                <span class="fw-semibold">{{ $product->name }}</span>
                                <span class="text-muted small">{{ $product->total_qty ?? 0 }} sold</span>
                            </div>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar bg-gold" style="width: {{ min(100, ($product->total_qty ?? 0) * 5) }}%"></div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <p class="text-muted text-center">No sales data yet</p>
                    @endforelse
                    <hr>
                    <a href="#" class="btn btn-outline-secondary w-100">View Full Report</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-12">
            <div class="card modern-card">
                <div class="card-header bg-transparent border-0">
                    <h5 class="fw-bold mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3 col-6">
                            <a href="{{ route('admin.products.create') }}" class="btn btn-outline-gold w-100 py-3">
                                <i class="fas fa-plus-circle mb-2"></i><br>New Product
                            </a>
                        </div>
                        <div class="col-md-3 col-6">
                            <a href="{{ route('admin.categories.create') }}" class="btn btn-outline-gold w-100 py-3">
                                <i class="fas fa-layer-group mb-2"></i><br>New Category
                            </a>
                        </div>
                        <div class="col-md-3 col-6">
                            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-gold w-100 py-3">
                                <i class="fas fa-truck mb-2"></i><br>Manage Orders
                            </a>
                        </div>
                        <div class="col-md-3 col-6">
                            <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-gold w-100 py-3">
                                <i class="fas fa-chart-pie mb-2"></i><br>Reports
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Modern card styling */
    .glass-card {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 20px;
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .glass-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }
    .modern-card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.02);
        transition: box-shadow 0.3s;
    }
    .modern-card:hover {
        box-shadow: 0 10px 30px rgba(212,175,55,0.1);
    }
    .icon-box {
        width: 48px;
        height: 48px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }
    .avatar-circle {
        width: 32px;
        height: 32px;
        background-color: var(--gold);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--dark);
        font-weight: 600;
    }
    .btn-outline-gold {
        border: 1px solid var(--gold);
        color: var(--dark);
        border-radius: 12px;
        transition: 0.3s;
    }
    .btn-outline-gold:hover {
        background-color: var(--gold);
        color: var(--dark);
        border-color: var(--gold);
    }
    .progress-bar.bg-gold {
        background-color: var(--gold) !important;
    }
    .badge.bg-gold-light {
        background-color: rgba(212,175,55,0.1);
        color: var(--dark);
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Revenue chart (area with gradient)
    const ctx = document.getElementById('revenueChart').getContext('2d');
    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(212, 175, 55, 0.5)');
    gradient.addColorStop(1, 'rgba(212, 175, 55, 0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartLabels ?? []) !!},
            datasets: [{
                label: 'Revenue',
                data: {!! json_encode($chartCounts ?? []) !!},
                backgroundColor: gradient,
                borderColor: '#D4AF37',
                borderWidth: 2,
                pointBackgroundColor: '#D4AF37',
                pointBorderColor: '#fff',
                pointHoverRadius: 6,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) { return '₹' + value; }
                    }
                }
            }
        }
    });

    // Donut chart for order status
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: ['Pending', 'Processing', 'Delivered', 'Cancelled'],
            datasets: [{
                data: [
                    {{ $pendingOrders ?? 0 }},
                    {{ $processingOrders ?? 0 }},
                    {{ $deliveredOrders ?? 0 }},
                    {{ $cancelledOrders ?? 0 }}
                ],
                backgroundColor: [
                    '#ffc107',
                    '#17a2b8',
                    '#28a745',
                    '#6c757d'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { display: false }
            },
            cutout: '70%'
        }
    });
});
</script>
@endpush