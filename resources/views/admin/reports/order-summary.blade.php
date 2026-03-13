@extends('admin.layouts.app')

@section('title','Order Summary')

@section('content')
<div class="container-fluid">

<h2 class="mb-4">Order Summary</h2>

<table class="table table-bordered">

<thead>
<tr>
<th>Status</th>
<th>Total Orders</th>
</tr>
</thead>

<tbody>

@foreach($summary as $status => $count)
<tr>
<td>{{ ucfirst($status) }}</td>
<td>{{ $count }}</td>
</tr>
@endforeach

</tbody>

</table>

</div>
@endsection