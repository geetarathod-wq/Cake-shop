@extends('admin.layouts.app')

@section('title','Category Sales')

@section('content')

<div class="container-fluid">

<h2 class="mb-4">Category Sales Report</h2>

<table class="table table-bordered">

<thead>
<tr>
<th>Category</th>
<th>Orders</th>
<th>Revenue</th>
</tr>
</thead>

<tbody>

@foreach($categories as $category)

<tr>
<td>{{ $category->name }}</td>
<td>{{ $category->orders }}</td>
<td>₹{{ number_format($category->revenue,2) }}</td>
</tr>

@endforeach

</tbody>

</table>

</div>

@endsection