<!DOCTYPE html>
<html>
<head>
    <title>Category Sales Report</title>
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
    <h2>Category Sales</h2>
    <p>From: {{ $start }} To: {{ $end }}</p>

    <table>
        <thead>
            <tr>
                <th>Category</th>
                <th class="text-right">Products</th>
                <th class="text-right">Total Quantity</th>
                <th class="text-right">Total Revenue</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
            <tr>
                <td>{{ $item->category_name }}</td>
                <td class="text-right">{{ $item->product_count }}</td>
                <td class="text-right">{{ $item->total_quantity }}</td>
                <td class="text-right text-gold">₹{{ number_format($item->total_revenue, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>