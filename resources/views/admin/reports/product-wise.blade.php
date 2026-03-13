@extends('admin.layouts.app')

@section('title','Product Wise Sales')

@section('content')

<div class="container-fluid">

<h2 class="mb-4">Product Wise Sales</h2>

<table class="table table-bordered">

<thead>
<tr>
<th>Product</th>
<th>Quantity Sold</th>
<th>Revenue</th>
</tr>
</thead>

<tbody>

@foreach($products as $product)

<tr>
<td>{{ $product->name }}</td>
<td>{{ $product->qty }}</td>
<td>₹{{ number_format($product->revenue,2) }}</td>
</tr>

@endforeach

</tbody>

</table>

</div>

@endsection