<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders | Blonde Bakery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f9f7f2; font-family: 'Montserrat', sans-serif; padding: 2rem; }
        .btn-luxury { background: #1A1A1A; color: white; border: none; padding: 10px 25px; text-transform: uppercase; letter-spacing: 2px; font-size: 0.8rem; text-decoration: none; }
        .btn-luxury:hover { background: #D4AF37; color: #1A1A1A; }
    </style>
</head>
<body>
<div class="container">
    <h1 class="mb-4">My Orders</h1>
    @auth
        @php
            $orders = \App\Models\Order::where('user_id', auth()->id())
                        ->with('items.product')
                        ->latest()
                        ->get();
        @endphp
        @if($orders->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered bg-white">
                    <thead class="table-light">
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
                                    {{ $item->product->name ?? 'Product' }} x{{ $item->quantity }} ({{ $item->weight }}kg)<br>
                                @endforeach
                            </td>
                            <td>₹{{ number_format($order->total_amount, 2) }}</td>
                            <td>
                                <span class="badge bg-{{ $order->status == 'pending' ? 'warning' : ($order->status == 'delivered' ? 'success' : 'secondary') }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <a href="{{ route('home') }}" class="btn btn-luxury mt-3">Continue Shopping</a>
        @else
            <p class="text-muted">You haven't placed any orders yet.</p>
            <a href="{{ route('home') }}" class="btn btn-luxury">Start Shopping</a>
        @endif
    @else
        <p>Please <a href="{{ route('login') }}">login</a> to view your orders.</p>
    @endauth
</div>
</body>
</html>