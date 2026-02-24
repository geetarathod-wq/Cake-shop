@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <i class="fas fa-check-circle fa-4x text-success"></i>
        <h1 class="serif display-5 mt-3">Thank You!</h1>
        <p class="lead">Your order has been placed successfully.</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Order Details #{{ $order->id }}</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr><th>Name:</th><td>{{ $order->name }}</td></tr>
                        <tr><th>Email:</th><td>{{ $order->email }}</td></tr>
                        <tr><th>Phone:</th><td>{{ $order->phone }}</td></tr>
                        <tr><th>Address:</th><td>{{ $order->address }}</td></tr>
                        <tr><th>Delivery Date:</th><td>{{ \Carbon\Carbon::parse($order->delivery_date)->format('d M Y') }}</td></tr>
                        <tr><th>Payment Method:</th><td>{{ $order->payment_method == 'cod' ? 'Cash on Delivery' : 'Online Payment' }}</td></tr>
                        <tr><th>Coupon:</th><td>{{ $order->coupon_code ?? 'None' }}</td></tr>
                        <tr><th>Total Amount:</th><td class="fw-bold">₹{{ number_format($order->total_amount, 2) }}</td></tr>
                    </table>

                    <h6 class="fw-bold mt-4">Items:</h6>
                    <ul class="list-group">
                        @foreach($order->items as $item)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $item->product->name }} x{{ $item->quantity }} ({{ $item->weight }}kg)
                                <span class="badge bg-gold-light text-dark">₹{{ number_format($item->price * $item->quantity, 2) }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="card-footer bg-white py-3 text-center">
                    <a href="{{ route('customer.orders') }}" class="btn btn-gold">
                        <i class="fas fa-truck me-2"></i>Track Your Order
                    </a>
                    <a href="{{ route('home') }}" class="btn btn-outline-secondary ms-2">
                        Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection