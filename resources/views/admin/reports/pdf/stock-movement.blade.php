<!DOCTYPE html>
<html>
<head>
    <title>Stock Movement</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background: #f2f2f2; }
        .text-right { text-align: right; }
        .text-success { color: green; }
        .text-primary { color: blue; }
        .text-danger { color: red; }
    </style>
</head>
<body>
    <h2>Stock Movement</h2>
    <p>From: {{ $start }} To: {{ $end }}</p>

    <table>
        <thead>
            <tr>
                <th>Ingredient</th>
                <th class="text-right">Added</th>
                <th class="text-right">Used</th>
                <th class="text-right">Waste</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
            <tr>
                <td>{{ $item['name'] }}</td>
                <td class="text-right text-success">{{ $item['added'] }}</td>
                <td class="text-right text-primary">{{ $item['used'] }}</td>
                <td class="text-right text-danger">{{ $item['waste'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>