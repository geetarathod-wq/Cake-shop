<!DOCTYPE html>
<html>
<head>
    <title>Low Stock Alert</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background: #f2f2f2; }
        .text-right { text-align: right; }
        .text-danger { color: red; }
    </style>
</head>
<body>
    <h2>Low Stock Alert</h2>
    <p>From: {{ $start }} To: {{ $end }}</p>

    @if(empty($data))
        <p>No low stock items found.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th class="text-right">Current Stock</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $item)
                <tr>
                    <td>{{ $item['product_name'] ?? $item['name'] ?? 'Unknown' }}</td>
                    <td class="text-right @if(($item['current_stock'] ?? $item['stock'] ?? 0) < 5) text-danger @endif">
                        {{ $item['current_stock'] ?? $item['stock'] ?? 0 }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>
</html>