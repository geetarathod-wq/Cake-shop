@extends('layouts.app')

@section('title', 'Order Details')

@push('styles')
    <style>
        .details-header {
            background: linear-gradient(135deg, var(--dark), var(--gold));
            color: white;
            padding: 40px 0;
            margin-bottom: 40px;
            text-align: center;
        }
        .details-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.03);
            overflow: hidden;
        }
        .details-card .card-header {
            background: #faf8f5;
            padding: 20px 25px;
            border-bottom: 1px solid #eee;
        }
        .details-card .card-header h3 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.8rem;
            margin: 0;
            color: var(--dark);
        }
        .details-card .card-body {
            padding: 30px;
        }
        .detail-row {
            display: flex;
            margin-bottom: 12px;
            border-bottom: 1px dashed #f0f0f0;
            padding-bottom: 8px;
        }
        .detail-label {
            width: 150px;
            font-weight: 600;
            color: #666;
        }
        .detail-value {
            flex: 1;
            color: var(--dark);
        }
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
        .btn-back {
            background: transparent;
            border: 2px solid var(--gold);
            color: var(--dark);
            padding: 10px 25px;
            border-radius: 50px;
            transition: 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        .btn-back:hover {
            background: var(--gold);
            color: var(--dark);
        }
    </style>
@endpush

@section('content')
    <div class="details-header">
        <h1 class="serif display-5">Order Details</h1>
        <p class="lead">#{{ $order->id }}</p>
    </div>

    <div class="container pb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="details-card">
                    <div class="card-header">
                        <h3>Order #{{ $order->id }} <span class="badge bg-{{ $order->status == 'delivered' ? 'success' : ($order->status == 'pending' ? 'warning' : 'secondary') }} text-white float-end">{{ ucfirst($order->status) }}</span></h3>
                    </div>
                    <div class="card-body">
                        <div class="detail-row">
                            <span class="detail-label">Date:</span>
                            <span class="detail-value">{{ $order->created_at->format('d M Y, h:i A') }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Name:</span>
                            <span class="detail-value">{{ $order->name }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Email:</span>
                            <span class="detail-value">{{ $order->email }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Phone:</span>
                            <span class="detail-value">{{ $order->phone }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Address:</span>
                            <span class="detail-value">{{ $order->address }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Delivery Date:</span>
                            <span class="detail-value">{{ \Carbon\Carbon::parse($order->delivery_date)->format('d M Y') }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Payment Method:</span>
                            <span class="detail-value">{{ $order->payment_method == 'cod' ? 'Cash on Delivery' : 'Online Payment' }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Coupon:</span>
                            <span class="detail-value">{{ $order->coupon_code ?? 'None' }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Total Amount:</span>
                            <span class="detail-value fw-bold">₹{{ number_format($order->total_amount, 2) }}</span>
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

                        <div class="text-center mt-4">
                            <a href="{{ route('customer.orders') }}" class="btn-back">
                                <i class="fa-regular fa-arrow-left me-2"></i>Back to My Orders
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection