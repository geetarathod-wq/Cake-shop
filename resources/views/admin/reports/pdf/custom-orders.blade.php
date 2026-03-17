<!DOCTYPE html>
<html>
<head>
    <title>Custom Cake Orders</title>
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
    <h2>Custom Cake Orders</h2>
    <p>From: {{ $start }} To: {{ $end }}</p>

    <table>
        <thead>
            <tr>
                <th>Order #</th>
                <th>Customer</th>
                <th>Message</th>
                <th>Instructions</th>
                <th class="text-right">Amount</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
            <tr>
                <td>{{ $item['order_number'] }}</td>
                <td>{{ $item['customer_name'] }}</td>
                <td>{{ $item['cake_message'] ?? '-' }}</td>
                <td>{{ $item['special_instructions'] ?? '-' }}</td>
                <td class="text-right text-gold">₹{{ number_format($item['total_amount'], 2) }}</td>
                <td>{{ $item['status'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>