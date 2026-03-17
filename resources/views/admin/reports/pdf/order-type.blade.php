<!DOCTYPE html>
<html>
<head>
    <title>Pre-order vs Walk-in</title>
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
    <h2>Pre-order vs Walk-in Comparison</h2>
    <p>From: {{ $start }} To: {{ $end }}</p>

    <table>
        <thead>
            <tr>
                <th>Type</th>
                <th class="text-right">Orders</th>
                <th class="text-right">Revenue</th>
                <th class="text-right">Average</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Pre-orders</td>
                <td class="text-right">{{ $data['pre_orders']['count'] }}</td>
                <td class="text-right text-gold">₹{{ number_format($data['pre_orders']['revenue'], 2) }}</td>
                <td class="text-right">₹{{ number_format($data['pre_orders']['average'], 2) }}</td>
            </tr>
            <tr>
                <td>Walk-in</td>
                <td class="text-right">{{ $data['walk_in']['count'] }}</td>
                <td class="text-right text-gold">₹{{ number_format($data['walk_in']['revenue'], 2) }}</td>
                <td class="text-right">₹{{ number_format($data['walk_in']['average'], 2) }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>