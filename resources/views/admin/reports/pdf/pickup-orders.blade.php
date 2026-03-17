<!DOCTYPE html>
<html>
<head>
    <title>Pickup Orders</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background: #f2f2f2; }
        .text-right { text-align: right; }
        .text-gold { color: #b8860b; }
    </style>
</head>
<body>
    <h2>Pickup Orders</h2>
    <p>From: {{ $start }} To: {{ $end }}</p>

    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Pickup Date</th>
                <th>Slot</th>
                <th>Status</th>
                <th class="text-right">Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $order)
            <tr>
                <td>#{{ $order['id'] }}</td>
                <td>{{ $order['name'] }}</td>
                <td>{{ $order['pickup_date'] }}</td>
                <td>{{ $order['pickup_slot'] }}</td>
                <td>{{ $order['status'] }}</td>
                <td class="text-right text-gold">₹{{ number_format($order['total_amount'], 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>