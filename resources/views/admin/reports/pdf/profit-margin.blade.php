<!DOCTYPE html>
<html>
<head>
    <title>Profit Margin Report</title>
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
    <h2>Profit Margin Report</h2>
    <p>From: {{ $start }} To: {{ $end }}</p>

    @if(empty($data))
        <p>No profit margin data available.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th class="text-right">Price</th>
                    <th class="text-right">Cost</th>
                    <th class="text-right">Qty</th>
                    <th class="text-right">Revenue</th>
                    <th class="text-right">Profit</th>
                    <th class="text-right">Margin %</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $item)
                <tr>
                    <td>{{ $item->product_name }}</td>
                    <td class="text-right">₹{{ number_format($item->price, 2) }}</td>
                    <td class="text-right">₹{{ number_format($item->cost_total / max($item->quantity,1), 2) }}</td>
                    <td class="text-right">{{ $item->quantity }}</td>
                    <td class="text-right text-gold">₹{{ number_format($item->revenue, 2) }}</td>
                    <td class="text-right">₹{{ number_format($item->profit, 2) }}</td>
                    <td class="text-right">{{ $item->margin }}%</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>
</html>