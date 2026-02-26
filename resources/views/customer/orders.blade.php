@extends('layouts.app')

@section('title', 'My Orders')

@push('styles')
    <style>
        .orders-header {
            background: linear-gradient(135deg, var(--dark), var(--gold));
            color: white;
            padding: 60px 0 40px;
            margin-bottom: 40px;
            border-radius: 0 0 50px 50px;
            text-align: center;
        }
        .order-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.03);
            transition: 0.3s;
            overflow: hidden;
            border: none;
            margin-bottom: 30px;
        }
        .order-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(212,175,55,0.1);
        }
        .order-header {
            padding: 20px 25px;
            background: #faf8f5;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }
        .order-id {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--dark);
        }
        .order-status {
            padding: 5px 15px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: capitalize;
        }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-processing { background: #d1ecf1; color: #0c5460; }
        .status-delivered { background: #d4edda; color: #155724; }
        .status-cancelled { background: #f8d7da; color: #721c24; }
        .order-body {
            padding: 20px 25px;
        }
        .order-meta {
            display: flex;
            gap: 30px;
            flex-wrap: wrap;
            margin-bottom: 15px;
            color: #666;
        }
        .order-meta p {
            margin: 0;
        }
        .order-meta strong {
            color: var(--dark);
            font-weight: 600;
        }
        .order-items {
            list-style: none;
            padding: 0;
            margin: 0 0 20px 0;
            background: #f9f9f9;
            border-radius: 12px;
            padding: 15px;
        }
        .order-items li {
            padding: 5px 0;
            border-bottom: 1px dashed #ddd;
            display: flex;
            justify-content: space-between;
        }
        .order-items li:last-child {
            border-bottom: none;
        }
        .btn-view {
            background: var(--dark);
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 50px;
            transition: 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        .btn-view:hover {
            background: var(--gold);
            color: var(--dark);
        }
        .empty-orders {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.03);
        }
        .empty-orders i {
            font-size: 4rem;
            color: #ddd;
            margin-bottom: 20px;
        }
        .empty-orders h3 {
            font-family: 'Cormorant Garamond', serif;
            margin-bottom: 10px;
        }
    </style>
@endpush

@section('content')
    <div class="orders-header">
        <h1 class="serif display-5">My Orders</h1>
        <p class="lead">Track and review your sweet memories</p>
    </div>

    <div class="container pb-5">
        <!-- Home link added here -->
        <div class="d-flex justify-content-start mb-4">
            <a href="{{ route('home') }}" class="text-decoration-none text-muted">
                <i class="fa-regular fa-arrow-left me-2"></i>Continue Shopping
            </a>
        </div>

        @if($orders->count() > 0)
            @foreach($orders as $order)
                <div class="order-card">
                    <div class="order-header">
                        <span class="order-id">Order #{{ $order->id }}</span>
                        <span class="order-status status-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
                    </div>
                    <div class="order-body">
                        <div class="order-meta">
                            <p><strong>Date:</strong> {{ $order->created_at->format('d M Y, h:i A') }}</p>
                            <p><strong>Total:</strong> ₹{{ number_format($order->total_amount, 2) }}</p>
                        </div>
                        <ul class="order-items">
                            @foreach($order->items as $item)
                                <li>
                                    <span>{{ $item->product->name }} x{{ $item->quantity }} ({{ $item->weight }}kg)</span>
                                    <span>₹{{ number_format($item->price * $item->quantity, 2) }}</span>
                                </li>
                            @endforeach
                        </ul>
                        <a href="{{ route('order.details', $order->id) }}" class="btn-view">View Details</a>
                    </div>
                </div>
            @endforeach
        @else
            <div class="empty-orders">
                <i class="fa-regular fa-clipboard"></i>
                <h3>No orders yet</h3>
                <p class="text-muted">Looks like you haven't placed any orders with us.</p>
                <a href="{{ route('home') }}" class="btn-luxury mt-3">Start Shopping</a>
            </div>
        @endif
    </div>
@endsection