@extends('admin.layouts.app')

@section('title','New vs Returning Customers')

@section('content')

<div class="container-fluid">

<h2 class="mb-4">New vs Returning Customers</h2>

<table class="table table-bordered">

<thead>
<tr>
<th>Type</th>
<th>Total Customers</th>
</tr>
</thead>

<tbody>

<tr>
<td>New Customers</td>
<td>{{ $newCustomers }}</td>
</tr>

<tr>
<td>Returning Customers</td>
<td>{{ $returningCustomers }}</td>
</tr>

</tbody>

</table>

</div>

@endsection