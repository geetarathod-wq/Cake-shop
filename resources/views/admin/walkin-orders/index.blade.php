@extends('admin.layouts.app')

@section('title', 'Walk-In Orders - Blonde Bakery Admin')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 fw-bold">Walk-In Orders</h1>
        <a href="{{ route('admin.walkin-orders.create') }}" class="btn btn-gold">
            <i class="fas fa-plus-circle me-2"></i>New Walk-In Order
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card modern-card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Phone</th>
                            <th>Order Date</th>
                            <th>Delivery Date</th>
                            <th>Order Type</th>
                            <th>Payment Method</th>
                            <th>Payment Status</th>
                            <th>Subtotal</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->customer_name }}</td>
                            <td>{{ $order->phone }}</td>
                            <td>{{ $order->order_date->format('d M Y') }}</td>
                            <td>{{ $order->delivery_date->format('d M Y') }}</td>
                            <td>{{ ucfirst($order->order_type) }}</td>
                            <td>{{ strtoupper($order->payment_method) }}</td>
                            <td>
                                @php
                                    $statusClass = match($order->payment_status) {
                                        'paid' => 'success',
                                        'pending' => 'warning',
                                        'failed' => 'danger',
                                        default => 'secondary'
                                    };
                                @endphp
                                <span class="badge bg-{{ $statusClass }} bg-opacity-10 text-{{ $statusClass }} rounded-full px-3 py-2">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </td>
                            <td>₹{{ number_format($order->subtotal, 2) }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.walkin-orders.show', $order) }}" class="btn btn-sm btn-outline-info" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.walkin-orders.edit', $order) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.walkin-orders.destroy', $order) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this order?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center py-5">
                                <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No walk-in orders found.</p>
                                <a href="{{ route('admin.walkin-orders.create') }}" class="btn btn-gold">
                                    Create First Order
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($orders->hasPages())
        <div class="card-footer bg-transparent">
            {{ $orders->links() }}
        </div>
        @endif
    </div>
</div>
@endsection