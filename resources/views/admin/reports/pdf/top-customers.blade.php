<!DOCTYPE html>
<html>
<head>
    <title>Top Customers</title>
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
    <h2>Top Customers</h2>
    <p>From: {{ $start }} To: {{ $end }}</p>

    <table>
        <thead>
            <tr>
                <th>Rank</th>
                <th>Name</th>
                <th>Email</th>
                <th class="text-right">Orders</th>
                <th class="text-right">Total Spent</th>
                <th class="text-right">Average Order</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $customer)
            <tr>
                <td>#{{ $customer['rank'] }}</td>
                <td>{{ $customer['name'] }}</td>
                <td>{{ $customer['email'] }}</td>
                <td class="text-right">{{ $customer['total_orders'] }}</td>
                <td class="text-right text-gold">₹{{ number_format($customer['total_spent'], 2) }}</td>
                <td class="text-right">₹{{ number_format($customer['average_order'], 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>