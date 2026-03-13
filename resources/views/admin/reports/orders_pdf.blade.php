<!DOCTYPE html>
<html>
<head>

<title>Sales Report</title>

<style>

body{font-family:DejaVu Sans;}

table{
width:100%;
border-collapse:collapse;
}

th,td{
border:1px solid #000;
padding:8px;
font-size:12px;
}

th{
background:#f2f2f2;
}

</style>

</head>

<body>

<h2>Monthly Sales Report</h2>

<table>

<thead>

<tr>
<th>ID</th>
<th>Customer</th>
<th>Total</th>
<th>Status</th>
<th>Date</th>
</tr>

</thead>

<tbody>

@foreach($orders as $order)

<tr>
<td>#{{ $order->id }}</td>
<td>{{ $order->customer_name }}</td>
<td>₹{{ $order->total }}</td>
<td>{{ $order->status }}</td>
<td>{{ $order->created_at->format('d M Y') }}</td>
</tr>

@endforeach

</tbody>

</table>

</body>
</html>