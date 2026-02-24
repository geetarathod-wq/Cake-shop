@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="serif mb-4">My Orders</h1>
    @if($orders->count())
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Date</th>
                        <th>Items</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td>#{{ $order->id }}</td>
                        <td>{{ $order->created_at->format('d M Y') }}</td>
                        <td>
                            @foreach($order->items as $item)
                                {{ $item->product->name }} x{{ $item->quantity }} ({{ $item->weight }}kg)<br>
                            @endforeach
                        </td>
                        <td>₹{{ number_format($order->total_amount, 2) }}</td>
                        <td><span class="badge bg-{{ $order->status == 'pending' ? 'warning' : 'success' }}">{{ ucfirst($order->status) }}</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-muted">You haven't placed any orders yet.</p>
        <a href="{{ route('home') }}" class="btn btn-gold">Start Shopping</a>
    @endif
</div>
@endsection