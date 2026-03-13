@extends('admin.layouts.app')

@section('title','Top Customers')

@section('content')

<div class="container-fluid">

<h2 class="mb-4">Top Customers</h2>

<table class="table table-bordered">

<thead>
<tr>
<th>Customer</th>
<th>Email</th>
<th>Total Orders</th>
<th>Total Spent</th>
</tr>
</thead>

<tbody>

@foreach($customers as $customer)
<tr>
<td>{{ $customer->name }}</td>
<td>{{ $customer->email }}</td>
<td>{{ $customer->orders }}</td>
<td>₹{{ number_format($customer->spent,2) }}</td>
</tr>
@endforeach

</tbody>

</table>

</div>

@endsection