@extends('layouts.app')

@section('title', 'Track Order #'.$order->id)

@push('styles')
    <style>
        .track-header {
            background: linear-gradient(135deg, var(--dark), var(--gold));
            color: white;
            padding: 60px 0;
            margin-bottom: 50px;
            text-align: center;
        }
        .track-card {
            background: white;
            border-radius: 30px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.05);
            overflow: hidden;
            border: none;
        }
        .track-card .card-header {
            background: #faf8f5;
            padding: 25px 30px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .track-card .card-header h3 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2rem;
            margin: 0;
            color: var(--dark);
        }
        .track-card .card-body {
            padding: 30px;
        }
        .order-detail-row {
            display: flex;
            margin-bottom: 12px;
            border-bottom: 1px dashed #f0f0f0;
            padding-bottom: 8px;
        }
        .order-detail-label {
            width: 150px;
            font-weight: 600;
            color: #666;
        }
        .order-detail-value {
            flex: 1;
            color: var(--dark);
        }
        .status-badge {
            display: inline-block;
            padding: 8px 20px;
            border-radius: 50px;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 1px;
        }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-processing { background: #cce5ff; color: #004085; }
        .status-shipped { background: #d4edda; color: #155724; }
        .status-delivered { background: #d4edda; color: #155724; }
        .status-cancelled { background: #f8d7da; color: #721c24; }
        .items-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 10px;
        }
        .items-table th {
            text-align: left;
            color: #999;
            font-weight: 500;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 1px;
        }
        .items-table td {
            padding: 10px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        .items-table tr:last-child td {
            border-bottom: none;
        }
        .item-name {
            font-weight: 500;
        }
        .item-qty {
            color: #888;
        }
        .item-price {
            font-weight: 600;
            color: var(--gold);
        }
        .action-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 30px;
        }
        .btn-gold-outline {
            background: transparent;
            border: 2px solid var(--gold);
            color: var(--dark);
            padding: 12px 35px;
            border-radius: 50px;
            font-weight: 600;
            transition: 0.3s;
            text-decoration: none;
        }
        .btn-gold-outline:hover {
            background: var(--gold);
            color: var(--dark);
        }
    </style>
@endpush

@section('content')
    <div class="track-header">
        <i class="fa-regular fa-truck fa-3x mb-3"></i>
        <h1 class="serif display-5">Track Order #{{ $order->id }}</h1>
        <p class="lead">Check the status of your order</p>
    </div>

    <div class="container pb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="track-card">
                    <div class="card-header">
                        <h3>Order Details</h3>
                        @php
                            $statusClass = '';
                            switch($order->status) {
                                case 'pending': $statusClass = 'status-pending'; break;
                                case 'processing': $statusClass = 'status-processing'; break;
                                case 'shipped': $statusClass = 'status-shipped'; break;
                                case 'delivered': $statusClass = 'status-delivered'; break;
                                case 'cancelled': $statusClass = 'status-cancelled'; break;
                                default: $statusClass = 'status-pending';
                            }
                        @endphp
                        <span class="status-badge {{ $statusClass }}">{{ ucfirst($order->status) }}</span>
                    </div>
                    <div class="card-body">
                        <div class="order-detail-row">
                            <span class="order-detail-label">Order Date:</span>
                            <span class="order-detail-value">{{ $order->created_at->format('d M Y, h:i A') }}</span>
                        </div>
                        <div class="order-detail-row">
                            <span class="order-detail-label">Name:</span>
                            <span class="order-detail-value">{{ $order->name }}</span>
                        </div>
                        <div class="order-detail-row">
                            <span class="order-detail-label">Email:</span>
                            <span class="order-detail-value">{{ $order->email }}</span>
                        </div>
                        <div class="order-detail-row">
                            <span class="order-detail-label">Phone:</span>
                            <span class="order-detail-value">{{ $order->phone }}</span>
                        </div>
                        <div class="order-detail-row">
                            <span class="order-detail-label">Address:</span>
                            <span class="order-detail-value">{{ $order->address }}</span>
                        </div>
                        <div class="order-detail-row">
                            <span class="order-detail-label">Delivery Date:</span>
                            <span class="order-detail-value">{{ \Carbon\Carbon::parse($order->delivery_date)->format('d M Y') }}</span>
                        </div>
                        <div class="order-detail-row">
                            <span class="order-detail-label">Payment Method:</span>
                            <span class="order-detail-value">{{ $order->payment_method == 'cod' ? 'Cash on Delivery' : 'Online Payment' }}</span>
                        </div>
                        <div class="order-detail-row">
                            <span class="order-detail-label">Coupon:</span>
                            <span class="order-detail-value">{{ $order->coupon_code ?? 'None' }}</span>
                        </div>
                        <div class="order-detail-row">
                            <span class="order-detail-label">Total Amount:</span>
                            <span class="order-detail-value fw-bold">₹{{ number_format($order->total_amount, 2) }}</span>
                        </div>

                        <h5 class="serif mt-4 mb-3">Items</h5>
                        <table class="items-table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Qty</th>
                                    <th>Weight</th>
                                    <th class="text-end">Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td class="item-name">{{ $item->product->name }}</td>
                                    <td class="item-qty">{{ $item->quantity }}</td>
                                    <td>{{ $item->weight }}kg</td>
                                    <td class="text-end item-price">₹{{ number_format($item->price * $item->quantity, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="action-buttons">
                            <a href="{{ route('customer.orders') }}" class="btn-gold-outline">
                                <i class="fa-regular fa-arrow-left me-2"></i>Back to My Orders
                            </a>
                            <a href="{{ route('home') }}" class="btn-luxury">Continue Shopping</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection