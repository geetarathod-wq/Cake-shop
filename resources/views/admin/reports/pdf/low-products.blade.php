<!DOCTYPE html>
<html>
<head>
    <title>Low Selling Products</title>
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
    <h2>Low Selling Products</h2>
    <p>From: {{ $start }} To: {{ $end }}</p>

    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Category</th>
                <th class="text-right">Price</th>
                <th class="text-right">Quantity Sold</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
            <tr>
                <td>{{ $item->product_name }}</td>
                <td>{{ $item->category }}</td>
                <td class="text-right">₹{{ number_format($item->price, 2) }}</td>
                <td class="text-right">{{ $item->quantity_sold }}</td>
                <td>{{ $item->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>