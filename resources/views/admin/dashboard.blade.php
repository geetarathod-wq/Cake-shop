@extends('admin.layouts.app')

@section('title', 'Dashboard - Blonde Bakery Admin')

@section('content')
<div class="container-fluid px-4">
    <!-- Welcome Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 fw-bold">Dashboard Overview</h1>
            <p class="text-muted">
                Welcome back, <strong>{{ Auth::user()->name ?? 'Admin' }}</strong>
                <span class="badge bg-warning text-dark ms-2">Administrator</span>
            </p>
        </div>
        <a href="{{ route('home') }}" class="btn btn-outline-secondary" target="_blank">
            <i class="fas fa-eye me-2"></i>View Site
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-5">
        <div class="col-xl-3 col-md-6">
            <div class="stat-card d-flex align-items-center">
                <div class="icon-box bg-gold-light me-3">
                    <i class="fas fa-box"></i>
                </div>
                <div>
                    <h6 class="text-muted mb-1">Total Orders</h6>
                    <h3 class="mb-0 fw-bold">{{ $totalOrders ?? 0 }}</h3>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card d-flex align-items-center">
                <div class="icon-box bg-gold-light me-3">
                    <i class="fas fa-clock"></i>
                </div>
                <div>
                    <h6 class="text-muted mb-1">Pending</h6>
                    <h3 class="mb-0 fw-bold">{{ $pendingOrders ?? 0 }}</h3>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card d-flex align-items-center">
                <div class="icon-box bg-gold-light me-3">
                    <i class="fas fa-indian-rupee-sign"></i>
                </div>
                <div>
                    <h6 class="text-muted mb-1">Revenue</h6>
                    <h3 class="mb-0 fw-bold">₹{{ number_format($totalRevenue ?? 0, 2) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card d-flex align-items-center">
                <div class="icon-box bg-gold-light me-3">
                    <i class="fas fa-cake-candles"></i>
                </div>
                <div>
                    <h6 class="text-muted mb-1">Active Products</h6>
                    <h3 class="mb-0 fw-bold">{{ $totalProducts ?? 0 }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders Table -->
    <div class="table-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="serif fw-bold mb-0">Recent Orders</h5>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-gold">
                View All <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>ORDER ID</th>
                        <th>CUSTOMER</th>
                        <th>DESIGN</th>
                        <th>DATE</th>
                        <th>STATUS</th>
                        <th class="text-end">TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentOrders ?? [] as $order)
                    <tr>
                        <td class="fw-medium">#{{ $order->id }}</td>
                        <td>{{ $order->name ?? $order->user->name ?? 'Guest' }}</td>
                        <td>
                            @if($order->items && $order->items->isNotEmpty())
                                @foreach($order->items->take(2) as $item)
                                    <div>{{ $item->product->name ?? 'Product' }}
                                        <span class="text-muted">x{{ $item->quantity }}</span>
                                    </div>
                                @endforeach
                                @if($order->items->count() > 2)
                                    <span class="text-muted small">+{{ $order->items->count() - 2 }} more</span>
                                @endif
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>{{ $order->created_at ? $order->created_at->format('M d, Y') : 'N/A' }}</td>
                        <td>
                            @php
                                $statusColor = match($order->status ?? 'pending') {
                                    'delivered' => 'success',
                                    'pending'   => 'warning',
                                    'processing'=> 'info',
                                    'cancelled' => 'danger',
                                    default     => 'secondary'
                                };
                            @endphp
                            <span class="badge bg-{{ $statusColor }} bg-opacity-10 text-{{ $statusColor }} px-3 py-2 rounded-pill">
                                {{ ucfirst($order->status ?? 'pending') }}
                            </span>
                        </td>
                        <td class="text-end fw-bold">₹{{ number_format($order->total_amount ?? 0, 2) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="fas fa-inbox fs-3 d-block mb-2"></i>
                            No orders yet.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection