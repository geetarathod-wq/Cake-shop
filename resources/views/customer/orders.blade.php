@extends('layouts.app')

@section('title', 'My Orders')

@push('styles')
    <style>
        .orders-header {
            background: linear-gradient(135deg, var(--dark), var(--gold));
            color: white;
            padding: 60px 0;
            margin-bottom: 40px;
            border-radius: 0 0 50px 50px;
        }
        .order-card {
            border-radius: 20px;
            transition: all 0.3s;
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.03);
            overflow: hidden;
        }
        .order-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(212,175,55,0.1);
        }
        .status-badge {
            padding: 5px 15px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        .status-pending { background: #ffeeba; color: #856404; }
        .status-processing { background: #b8daff; color: #004085; }
        .status-delivered { background: #c3e6cb; color: #155724; }
        .status-cancelled { background: #f5c6cb; color: #721c24; }
    </style>
@endpush

@section('content')
    <div class="orders-header text-center">
        <h1 class="serif display-5">My Orders</h1>
        <p class="lead">Track and review your sweet memories</p>
    </div>

    <div class="container pb-5">
        @if($orders->count())
            <div class="row">
                @foreach($orders as $order)
                <div class="col-lg-6 mb-4">
                    <div class="order-card card">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                            <span class="fw-bold">Order #{{ $order->id }}</span>
                            <span class="status-badge status-{{ $order->status }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                        <div class="card-body">
                            <p class="text-muted mb-2">{{ $order->created_at->format('d M Y, h:i A') }}</p>
                            <p class="mb-2"><strong>Total:</strong> ₹{{ number_format($order->total_amount, 2) }}</p>
                            <p class="mb-0"><strong>Items:</strong></p>
                            <ul class="list-unstyled ms-3">
                                @foreach($order->items as $item)
                                    <li>• {{ $item->product->name }} x{{ $item->quantity }} ({{ $item->weight }}kg)</li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="card-footer bg-white text-end">
                            <a href="#" class="btn btn-sm btn-outline-gold">View Details</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5">
                <i class="fa-regular fa-clipboard fa-3x text-muted mb-3"></i>
                <h3 class="serif">No orders yet</h3>
                <p class="text-muted">Looks like you haven't placed any orders with us.</p>
                <a href="{{ route('home') }}" class="btn-luxury mt-3">Start Shopping</a>
            </div>
        @endif
    </div>
@endsection