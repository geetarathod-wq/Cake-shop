<!DOCTYPE html>
<html>
<head>
    <title>New vs Returning Customers</title>
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
    <h2>New vs Returning Customers</h2>
    <p>From: {{ $start }} To: {{ $end }}</p>

    <table>
        <thead>
            <tr>
                <th>Type</th>
                <th class="text-right">Count</th>
                <th class="text-right">Revenue</th>
                <th class="text-right">Percentage</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>New Customers</td>
                <td class="text-right">{{ $data['new']['customer_count'] }}</td>
                <td class="text-right text-gold">₹{{ number_format($data['new']['revenue'], 2) }}</td>
                <td class="text-right">{{ $data['new']['percentage'] }}%</td>
            </tr>
            <tr>
                <td>Returning Customers</td>
                <td class="text-right">{{ $data['returning']['customer_count'] }}</td>
                <td class="text-right text-gold">₹{{ number_format($data['returning']['revenue'], 2) }}</td>
                <td class="text-right">{{ $data['returning']['percentage'] }}%</td>
            </tr>
        </tbody>
    </table>
</body>
</html>