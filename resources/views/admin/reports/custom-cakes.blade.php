@extends('admin.layouts.app')

@section('title','Custom Cake Orders')

@section('content')

<div class="container-fluid">

<h2 class="mb-4">Custom Cake Orders</h2>

<table class="table table-bordered">

<thead>
<tr>
<th>Order ID</th>
<th>Customer</th>
<th>Message</th>
<th>Delivery Date</th>
</tr>
</thead>

<tbody>

@foreach($orders as $order)
<tr>
<td>{{ $order->id }}</td>
<td>{{ $order->name }}</td>
<td>{{ $order->custom_message }}</td>
<td>{{ $order->delivery_date }}</td>
</tr>
@endforeach

</tbody>

</table>

</div>

@endsection