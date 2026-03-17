<!DOCTYPE html>
<html>
<head>
    <title>Customer Order Frequency</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background: #f2f2f2; }
        .text-right { text-align: right; }
    </style>
</head>
<body>
    <h2>Customer Order Frequency</h2>
    <p>From: {{ $start }} To: {{ $end }}</p>

    <table>
        <thead>
            <tr>
                <th>Frequency</th>
                <th class="text-right">Customers</th>
            </tr>
        </thead>
        <tbody>
            <tr><td>Weekly</td><td class="text-right">{{ $data['weekly'] }}</td></tr>
            <tr><td>Monthly</td><td class="text-right">{{ $data['monthly'] }}</td></tr>
            <tr><td>Quarterly</td><td class="text-right">{{ $data['quarterly'] }}</td></tr>
            <tr><td>Yearly</td><td class="text-right">{{ $data['yearly'] }}</td></tr>
            <tr><td>One-time</td><td class="text-right">{{ $data['one_time'] }}</td></tr>
        </tbody>
    </table>
</body>
</html>