@extends('admin.layouts.app')

@section('title','Order Type Comparison')

@section('content')

<div class="container-fluid">

<h2 class="mb-4">Online vs Walk-in Orders</h2>

<table class="table table-bordered">

<thead>
<tr>
<th>Order Type</th>
<th>Total Orders</th>
<th>Total Revenue</th>
</tr>
</thead>

<tbody>

@foreach($data as $row)
<tr>
<td>{{ ucfirst($row->order_type) }}</td>
<td>{{ $row->orders }}</td>
<td>₹{{ number_format($row->revenue,2) }}</td>
</tr>
@endforeach

</tbody>

</table>

</div>

@endsection