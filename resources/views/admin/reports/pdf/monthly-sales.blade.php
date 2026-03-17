<!DOCTYPE html>
<html>
<head>
    <title>Monthly Sales Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background: #f2f2f2; }
        .text-right { text-align: right; }
        .text-gold { color: #b8860b; }
    </style>
</head>
<body>
    <h2>Monthly Sales Overview</h2>
    <p>From: {{ $start }} To: {{ $end }}</p>

    <h3>Summary</h3>
    <table>
        <tr><th>Total Orders</th><td>{{ $data['current_month']['total_orders'] ?? 0 }}</td></tr>
        <tr><th>Total Revenue</th><td class="text-gold">₹{{ number_format($data['current_month']['total_revenue'] ?? 0, 2) }}</td></tr>
        <tr><th>Average Order</th><td>₹{{ number_format($data['current_month']['average_order'] ?? 0, 2) }}</td></tr>
        <tr><th>Growth</th><td>{{ $data['growth_percentage'] ?? 0 }}%</td></tr>
    </table>

    <h3>Daily Trend</h3>
    <table>
        <thead><tr><th>Date</th><th class="text-right">Orders</th><th class="text-right">Revenue</th></tr></thead>
        <tbody>
            @foreach($data['daily_trend'] as $day)
            <tr>
                <td>{{ $day->date }}</td>
                <td class="text-right">{{ $day->orders }}</td>
                <td class="text-right text-gold">₹{{ number_format($day->revenue, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>