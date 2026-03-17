<!DOCTYPE html>
<html>
<head>
    <title>Order Summary</title>
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
    <h2>Order Summary</h2>
    <p>From: {{ $start }} To: {{ $end }}</p>

    <h3>Total Orders: {{ $data['summary']['total_orders'] }} | Total Value: ₹{{ number_format($data['summary']['total_value'], 2) }}</h3>

    <table>
        <thead>
            <tr>
                <th>Status</th>
                <th class="text-right">Orders</th>
                <th class="text-right">Value</th>
                <th class="text-right">%</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data['data'] as $item)
            <tr>
                <td>{{ $item->status }}</td>
                <td class="text-right">{{ $item->order_count }}</td>
                <td class="text-right text-gold">₹{{ number_format($item->total_value, 2) }}</td>
                <td class="text-right">{{ number_format(($item->total_value / $data['summary']['total_value']) * 100, 1) }}%</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>