<!DOCTYPE html>
<html>
<head>
    <title>Daily Sales Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .text-right { text-align: right; }
        .text-gold { color: #b8860b; }
        h2 { color: #b8860b; }
    </style>
</head>
<body>
    <h2>Daily Sales Report</h2>
    <p>Date: {{ $start }}</p>

    <h3>Summary</h3>
    <table>
        <tr><th>Total Orders</th><td>{{ $data['summary']['total_orders'] }}</td></tr>
        <tr><th>Total Revenue</th><td class="text-gold">₹{{ number_format($data['summary']['total_revenue'], 2) }}</td></tr>
        <tr><th>Average Order Value</th><td>₹{{ number_format($data['summary']['average_order_value'], 2) }}</td></tr>
    </table>

    <h3>Payment Method Breakdown</h3>
    <table>
        <thead>
            <tr><th>Method</th><th class="text-right">Orders</th><th class="text-right">Revenue</th></tr>
        </thead>
        <tbody>
            @foreach($data['payment_breakdown'] as $item)
            <tr>
                <td>{{ $item->payment_method ?? 'N/A' }}</td>
                <td class="text-right">{{ $item->order_count }}</td>
                <td class="text-right text-gold">₹{{ number_format($item->revenue, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Orders by Status</h3>
    <table>
        <thead>
            <tr><th>Status</th><th class="text-right">Orders</th><th class="text-right">Revenue</th></tr>
        </thead>
        <tbody>
            @foreach($data['orders_by_status'] as $item)
            <tr>
                <td>{{ $item->status }}</td>
                <td class="text-right">{{ $item->count }}</td>
                <td class="text-right text-gold">₹{{ number_format($item->revenue, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>