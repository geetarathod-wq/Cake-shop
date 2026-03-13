@extends('admin.layouts.app')

@section('title','Customer Frequency')

@section('content')

<div class="container-fluid">

<h2 class="mb-4">Customer Frequency</h2>

<table class="table table-bordered">

<thead>
<tr>
<th>Customer</th>
<th>Total Orders</th>
</tr>
</thead>

<tbody>

@foreach($customers as $customer)
<tr>
<td>{{ $customer->name }}</td>
<td>{{ $customer->orders }}</td>
</tr>
@endforeach

</tbody>

</table>

</div>

@endsection