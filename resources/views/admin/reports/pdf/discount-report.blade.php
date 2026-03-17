<!DOCTYPE html>
<html>
<head>
    <title>Discount Impact Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background: #f2f2f2; }
        .text-right { text-align: right; }
        .text-gold { color: #b8860b; }
        .text-danger { color: red; }
    </style>
</head>
<body>
    <h2>Discount Impact Report</h2>
    <p>From: {{ $start }} To: {{ $end }}</p>

    <table>
        <tr><th>Total Orders</th><td>{{ $data['total_orders'] }}</td></tr>
        <tr><th>Discounted Orders</th><td>{{ $data['discounted_orders'] }}</td></tr>
        <tr><th>Total Discount Given</th><td class="text-danger">₹{{ number_format($data['total_discount_given'], 2) }}</td></tr>
        <tr><th>Average Discount</th><td class="text-gold">₹{{ number_format($data['average_discount'], 2) }}</td></tr>
        <tr><th>Revenue Impact</th><td>{{ $data['revenue_impact'] }}%</td></tr>
    </table>
</body>
</html>