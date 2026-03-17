<!DOCTYPE html>
<html>
<head>
    <title>Customer History</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background: #f2f2f2; }
        .text-right { text-align: right; }
        .text-gold { color: #b8860b; }
    </style>
</head>
<body>
    <h2>Customer History</h2>
    <p><strong>Customer:</strong> {{ $data['customer']['name'] }} ({{ $data['customer']['email'] }})</p>
    <p>Member since: {{ $data['customer']['member_since'] }} | Phone: {{ $data['customer']['phone'] }}</p>

    <h3>Summary</h3>
    <table>
        <tr><th>Total Orders</th><td>{{ $data['summary']['total_orders'] }}</td></tr>
        <tr><th>Total Spent</th><td class="text-gold">₹{{ number_format($data['summary']['total_spent'], 2) }}</td></tr>
        <tr><th>Average Order</th><td>₹{{ number_format($data['summary']['average_order'], 2) }}</td></tr>
    </table>

    <h3>Order History</h3>
    <table>
        <thead>
            <tr>
                <th>Order #</th>
                <th>Date</th>
                <th class="text-right">Amount</th>
                <th>Status</th>
                <th>Payment</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data['orders'] as $order)
            <tr>
                <td>{{ $order['order_number'] }}</td>
                <td>{{ $order['date'] }}</td>
                <td class="text-right text-gold">₹{{ number_format($order['total'], 2) }}</td>
                <td>{{ $order['status'] }}</td>
                <td>{{ $order['payment_method'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>