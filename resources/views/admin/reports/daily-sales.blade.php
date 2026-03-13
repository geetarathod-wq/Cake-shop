@extends('admin.layouts.app')

@section('title','Daily Sales Report')

@section('content')

<div class="container-fluid">

<h2 class="mb-4">Daily Sales Report</h2>

<form method="GET" class="mb-4">
    <label>Select Date:</label>
    <input type="date" name="date" value="{{ $date }}" class="form-control w-auto d-inline">
    <button type="submit" class="btn btn-gold">View</button>
</form>

<div class="row mb-4">

<div class="col-md-3">
<div class="card stat-card">
<div class="d-flex justify-content-between">
<div>
<p>Total Orders</p>
<h3>{{ $totalOrders }}</h3>
</div>
<i class="fa fa-shopping-bag"></i>
</div>
</div>
</div>

<div class="col-md-3">
<div class="card stat-card">
<div class="d-flex justify-content-between">
<div>
<p>Total Revenue</p>
<h3>₹{{ number_format($totalRevenue,2) }}</h3>
</div>
<i class="fa fa-coins"></i>
</div>
</div>
</div>

<div class="col-md-3">
<div class="card stat-card">
<div class="d-flex justify-content-between">
<div>
<p>COD</p>
<h3>₹{{ number_format($codTotal,2) }}</h3>
</div>
<i class="fa fa-money-bill"></i>
</div>
</div>
</div>

<div class="col-md-3">
<div class="card stat-card">
<div class="d-flex justify-content-between">
<div>
<p>Online</p>
<h3>₹{{ number_format($onlineTotal,2) }}</h3>
</div>
<i class="fa fa-credit-card"></i>
</div>
</div>
</div>

</div>

<div class="table-container">

<table class="table table-bordered">

<thead>
<tr>
<th>Order ID</th>
<th>Customer</th>
<th>Items</th>
<th>Total</th>
<th>Payment</th>
<th>Order Type</th>
<th>Time</th>
</tr>
</thead>

<tbody>

@forelse($orders as $order)

<tr>

<td>{{ $order->id }}</td>

<td>{{ $order->name }}</td>

<td>
@foreach($order->items as $item)
{{ $item->product->name }} ({{ $item->quantity }}) <br>
@endforeach
</td>

<td>₹{{ number_format($order->total_amount,2) }}</td>

<td>{{ ucfirst($order->payment_method) }}</td>

<td>{{ ucfirst($order->order_type) }}</td>

<td>{{ $order->created_at->format('H:i') }}</td>

</tr>

@empty

<tr>
<td colspan="7" class="text-center">No Orders Found</td>
</tr>

@endforelse

</tbody>

</table>

</div>

</div>

@endsection