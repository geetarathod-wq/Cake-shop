@extends('admin.layouts.app')

@section('title','Profit Margin')

@section('content')

<div class="container-fluid">

<h2 class="mb-4">Profit Margin Report</h2>

<table class="table table-bordered">

<thead>
<tr>
<th>Product</th>
<th>Cost</th>
<th>Price</th>
<th>Profit</th>
</tr>
</thead>

<tbody>

@foreach($products as $product)
<tr>
<td>{{ $product->name }}</td>
<td>₹{{ $product->cost }}</td>
<td>₹{{ $product->price }}</td>
<td>₹{{ $product->profit }}</td>
</tr>
@endforeach

</tbody>

</table>

</div>

@endsection