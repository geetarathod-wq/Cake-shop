@extends('admin.layouts.app')

@section('title', 'Walk-in Order Details - Blonde Bakery Admin')

@section('content')
<div class="container-fluid px-4 py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 fw-bold">Order {{ $walkInOrder->id }}</h1>
        <div>
            <a href="{{ url('admin/walkin-orders/' . $walkInOrder->id . '/edit') }}" class="btn btn-warning">
                <i class="fas fa-edit me-2"></i>Edit
            </a>

            <a href="{{ route('admin.walkin-orders.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to List
            </a>
        </div>
    </div>


    <div class="row">

        <!-- Customer Details -->
        <div class="col-md-6">
            <div class="card modern-card mb-4">
                <div class="card-header bg-transparent">
                    <h5 class="mb-0 fw-bold">Customer Details</h5>
                </div>

                <div class="card-body">

                    <p><strong>Name:</strong>
                        {{ $walkInOrder->customer_name ?? $walkInOrder->user->name ?? 'Guest' }}
                    </p>

                    <p><strong>Phone:</strong>
                        {{ $walkInOrder->phone ?? '—' }}
                    </p>

                    <p><strong>Email:</strong>
                        {{ $walkInOrder->email ?? '—' }}
                    </p>

                    <p><strong>Address:</strong>
                        {{ $walkInOrder->address ?? '—' }}
                    </p>

                </div>
            </div>
        </div>


        <!-- Order Details -->
        <div class="col-md-6">
            <div class="card modern-card mb-4">
                <div class="card-header bg-transparent">
                    <h5 class="mb-0 fw-bold">Order Details</h5>
                </div>

                <div class="card-body">

                    <p><strong>Order Date:</strong>
                        {{ $walkInOrder->created_at ? $walkInOrder->created_at->format('d M Y') : '—' }}
                    </p>

                    <p><strong>Delivery Date:</strong>
                        {{ $walkInOrder->delivery_date ? \Carbon\Carbon::parse($walkInOrder->delivery_date)->format('d M Y') : '—' }}
                    </p>

                    <p><strong>Order Source:</strong>
                        <span class="badge bg-warning text-dark">Walk-In</span>
                    </p>

                    <p><strong>Status:</strong>
                        <span class="badge bg-info">
                            {{ ucfirst($walkInOrder->status ?? 'pending') }}
                        </span>
                    </p>

                    <p><strong>Admin Note:</strong>
                        {{ $walkInOrder->admin_note ?? '—' }}
                    </p>

                </div>
            </div>
        </div>

    </div>


    <div class="row">

        <!-- Payment Details -->
        <div class="col-md-6">
            <div class="card modern-card mb-4">

                <div class="card-header bg-transparent">
                    <h5 class="mb-0 fw-bold">Payment Details</h5>
                </div>

                <div class="card-body">

                    <p><strong>Method:</strong>
                        {{ strtoupper($walkInOrder->payment_method ?? '—') }}
                    </p>

                    <p><strong>Status:</strong>

                        @php
                            $statusClass = match($walkInOrder->payment_status ?? 'pending') {
                                'paid' => 'success',
                                'pending' => 'warning',
                                'failed' => 'danger',
                                default => 'secondary'
                            };
                        @endphp

                        <span class="badge bg-{{ $statusClass }} bg-opacity-10 text-{{ $statusClass }} rounded-full px-3 py-2">
                            {{ ucfirst($walkInOrder->payment_status ?? 'pending') }}
                        </span>

                    </p>

                </div>
            </div>
        </div>


        <!-- Order Summary -->
        <div class="col-md-6">
            <div class="card modern-card mb-4">

                <div class="card-header bg-transparent">
                    <h5 class="mb-0 fw-bold">Order Summary</h5>
                </div>

                <div class="card-body">

                    <p><strong>Subtotal:</strong>
                        ₹{{ number_format($walkInOrder->total_amount ?? 0, 2) }}
                    </p>

                    <hr>

                    <p class="fw-bold fs-5">
                        Total: ₹{{ number_format($walkInOrder->total_amount ?? 0, 2) }}
                    </p>

                </div>
            </div>
        </div>

    </div>



    <!-- Ordered Products -->
    <div class="card modern-card">

        <div class="card-header bg-transparent">
            <h5 class="mb-0 fw-bold">Ordered Products</h5>
        </div>

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($walkInOrder->items as $item)

                        <tr>
                            <td>
                                {{ $item->product->name ?? 'Product' }}
                            </td>

                            <td>
                                {{ $item->quantity }}
                            </td>

                            <td>
                                ₹{{ number_format($item->price, 2) }}
                            </td>

                            <td>
                                ₹{{ number_format($item->subtotal, 2) }}
                            </td>
                        </tr>

                        @empty

                        <tr>
                            <td colspan="4" class="text-center py-3">
                                No items in this order.
                            </td>
                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>
    </div>

</div>
@endsection