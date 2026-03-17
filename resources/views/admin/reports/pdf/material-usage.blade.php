<!DOCTYPE html>
<html>
<head>
    <title>Raw Material Usage</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background: #f2f2f2; }
        .text-right { text-align: right; }
    </style>
</head>
<body>
    <h2>Raw Material Usage</h2>
    <p>From: {{ $start }} To: {{ $end }}</p>

    <table>
        <thead>
            <tr>
                <th>Ingredient</th>
                <th class="text-right">Used</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
            <tr>
                <td>{{ $item['name'] }}</td>
                <td class="text-right">{{ $item['used'] }} g/ml</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>