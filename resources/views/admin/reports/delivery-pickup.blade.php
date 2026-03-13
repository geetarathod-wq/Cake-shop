@extends('admin.layouts.app')

@section('title','Delivery vs Pickup')

@section('content')

<div class="container-fluid">

<h2 class="mb-4">Delivery vs Pickup Orders</h2>

<table class="table table-bordered">

<thead>
<tr>
<th>Type</th>
<th>Total Orders</th>
</tr>
</thead>

<tbody>

@foreach($data as $row)
<tr>
<td>{{ ucfirst($row->type) }}</td>
<td>{{ $row->orders }}</td>
</tr>
@endforeach

</tbody>

</table>

</div>

@endsection