@extends('admin.layouts.app')

@section('title','Top Selling Products')

@section('content')
<div class="container-fluid">

<h2 class="mb-4">Top Selling Products</h2>

<div class="table-container">
<table class="table table-bordered">

<thead>
<tr>
<th>Product</th>
<th>Category</th>
<th>Price</th>
<th>Quantity Sold</th>
</tr>
</thead>

<tbody>

@foreach($products as $product)
<tr>
<td>{{ $product->name }}</td>
<td>{{ $product->category_name }}</td>
<td>₹{{ number_format($product->price,2) }}</td>
<td>{{ $product->total_qty }}</td>
</tr>
@endforeach

</tbody>

</table>
</div>

</div>
@endsection