@extends('admin.layouts.app')

@section('title','Customer Order History')

@section('content')

<div class="container-fluid">

<h2 class="mb-4">Customer Order History</h2>

<table class="table table-bordered">

<thead>
<tr>
<th>Order ID</th>
<th>Customer</th>
<th>Total</th>
<th>Date</th>
</tr>
</thead>

<tbody>

@foreach($orders as $order)
<tr>
<td>{{ $order->id }}</td>
<td>{{ $order->name }}</td>
<td>₹{{ number_format($order->total_amount,2) }}</td>
<td>{{ $order->created_at }}</td>
</tr>
@endforeach

</tbody>

</table>

</div>

@endsection