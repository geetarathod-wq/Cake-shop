@extends('admin.layouts.app')

@section('title', 'Order Details')

@section('content')
<div class="container-fluid px-4 py-4">

    <h2 class="mb-4">Order {{ $order->id }}</h2>

    <div class="card mb-4">
        <div class="card-header">
            <strong>Customer Details</strong>
        </div>

        <div class="card-body">

            <p>
                <strong>Name:</strong>
                {{ $order->customer_name ?? $order->user->name ?? 'Guest' }}
            </p>

            <p>
                <strong>Phone:</strong>
                {{ $order->phone ?? '—' }}
            </p>

            <p>
                <strong>Email:</strong>
                {{ $order->email ?? '—' }}
            </p>

        </div>
    </div>


    <div class="card mb-4">
        <div class="card-header">
            <strong>Order Info</strong>
        </div>

        <div class="card-body">

            <p>
                <strong>Delivery Date:</strong>
                {{ $order->delivery_date }}
            </p>

            <p>
                <strong>Status:</strong>
                {{ ucfirst($order->status) }}
            </p>

            <p>
                <strong>Order Source:</strong>

                @if($order->order_source == 'walkin')
                    <span class="badge bg-warning text-dark">Walk-In</span>
                @else
                    <span class="badge bg-primary">Online</span>
                @endif

            </p>

            <p>
                <strong>Total Amount:</strong>
                ₹{{ number_format($order->total_amount,2) }}
            </p>

        </div>
    </div>


    <div class="card">
        <div class="card-header">
            <strong>Ordered Products</strong>
        </div>

        <div class="card-body p-0">

            <table class="table mb-0">

                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>

                <tbody>

                @foreach($order->items as $item)

                    <tr>
                        <td>{{ $item->product->name ?? 'Product' }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>₹{{ number_format($item->price,2) }}</td>
                        <td>₹{{ number_format($item->subtotal,2) }}</td>
                    </tr>

                @endforeach

                </tbody>

            </table>

        </div>
    </div>

</div>
@endsection