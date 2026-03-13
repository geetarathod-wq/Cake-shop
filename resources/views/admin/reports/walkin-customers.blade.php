@extends('admin.layouts.app')

@section('title', 'Walk‑in Customers - Blonde Bakery Admin')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Header with Create Button -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 fw-bold" style="background: linear-gradient(135deg, var(--dark), var(--gold)); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                Walk‑in Customers
            </h1>
            <p class="text-muted">All orders placed directly at the counter</p>
        </div>
        <a href="{{ route('admin.walkin-orders.create') }}" class="btn btn-gold">
            <i class="fas fa-plus-circle me-2"></i>New Walk‑in Order
        </a>
    </div>

    <!-- Orders Table Card -->
    <div class="card modern-card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>Order ID</th>
                            <th>Customer Details</th>
                            <th>Order & Delivery</th>
                            <th>Payment</th>
                            <th>Subtotal</th>
                            <th>Products</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td class="fw-medium">#{{ $order->id }}</td>
                            <td>
                                <strong>{{ $order->customer_name }}</strong><br>
                                <small class="text-muted">📞 {{ $order->phone }}</small><br>
                                @if($order->email)
                                    <small class="text-muted">✉️ {{ $order->email }}</small><br>
                                @endif
                                @if($order->address)
                                    <small class="text-muted">🏠 {{ $order->address }}</small>
                                @endif
                            </td>
                            <td>
                                <strong>Order:</strong> {{ $order->order_date->format('d M Y') }}<br>
                                <strong>Delivery:</strong> {{ $order->delivery_date->format('d M Y') }}<br>
                                <strong>Slot:</strong> {{ ucfirst($order->delivery_slot) }}<br>
                                <strong>Type:</strong> {{ ucfirst($order->order_type) }}<br>
                                @if($order->admin_note)
                                    <span class="badge bg-info bg-opacity-10 text-info" title="Admin Note">
                                        <i class="fas fa-sticky-note"></i> Note
                                    </span>
                                @endif
                            </td>
                            <td>
                                <strong>{{ strtoupper($order->payment_method) }}</strong><br>
                                @php
                                    $statusClass = match($order->payment_status) {
                                        'paid' => 'success',
                                        'pending' => 'warning',
                                        'failed' => 'danger',
                                        default => 'secondary'
                                    };
                                @endphp
                                <span class="badge bg-{{ $statusClass }} bg-opacity-10 text-{{ $statusClass }} rounded-full px-3 py-1">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </td>
                            <td class="fw-bold">₹{{ number_format($order->subtotal, 2) }}</td>
                            <td>
                                <button class="btn btn-sm btn-outline-gold" type="button" data-bs-toggle="collapse" data-bs-target="#products-{{ $order->id }}" aria-expanded="false">
                                    <i class="fas fa-eye"></i> View ({{ $order->items->count() }})
                                </button>
                                <div class="collapse mt-2" id="products-{{ $order->id }}">
                                    <ul class="list-unstyled small">
                                        @foreach($order->items as $item)
                                            <li>
                                                {{ $item->product->name ?? 'Deleted Product' }} 
                                                × {{ $item->quantity }} 
                                                @ ₹{{ number_format($item->price, 2) }} 
                                                = ₹{{ number_format($item->subtotal, 2) }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.walkin-orders.show', $order) }}" class="btn btn-sm btn-outline-info" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.walkin-orders.edit', $order) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.walkin-orders.destroy', $order) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this order?');">
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
                            <td colspan="7" class="text-center py-5">
                                <i class="fas fa-user-tie fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No walk‑in orders found.</p>
                                <a href="{{ route('admin.walkin-orders.create') }}" class="btn btn-gold">
                                    <i class="fas fa-plus-circle me-2"></i>Create First Walk‑in Order
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($orders->hasPages())
        <div class="card-footer bg-transparent d-flex justify-content-end">
            {{ $orders->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Optional: adjust collapse spacing */
    .collapse ul {
        padding-left: 0;
        margin-bottom: 0;
    }
    .collapse li {
        padding: 2px 0;
        border-bottom: 1px dashed #eee;
    }
    .collapse li:last-child {
        border-bottom: none;
    }
</style>
@endpush