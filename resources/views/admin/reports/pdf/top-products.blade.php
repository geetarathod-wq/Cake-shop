<!DOCTYPE html>
<html>
<head>
    <title>Top Selling Products</title>
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
    <h2>Top 10 Selling Products</h2>
    <p>From: {{ $start }} To: {{ $end }}</p>

    <table>
        <thead>
            <tr>
                <th>Rank</th>
                <th>Product</th>
                <th>Category</th>
                <th class="text-right">Quantity Sold</th>
                <th class="text-right">Revenue</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
            <tr>
                <td>#{{ $item->rank }}</td>
                <td>{{ $item->product_name }}</td>
                <td>{{ $item->category }}</td>
                <td class="text-right">{{ $item->quantity_sold }}</td>
                <td class="text-right text-gold">₹{{ number_format($item->revenue, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>