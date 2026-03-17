<!DOCTYPE html>
<html>
<head>
    <title>Payment Methods Report</title>
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
    <h2>Payment Methods Report</h2>
    <p>From: {{ $start }} To: {{ $end }}</p>

    <table>
        <thead>
            <tr>
                <th>Method</th>
                <th class="text-right">Orders</th>
                <th class="text-right">Revenue</th>
                <th class="text-right">%</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
            <tr>
                <td>{{ $item->payment_method }}</td>
                <td class="text-right">{{ $item->order_count }}</td>
                <td class="text-right text-gold">₹{{ number_format($item->revenue, 2) }}</td>
                <td class="text-right">{{ $item->percentage }}%</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>