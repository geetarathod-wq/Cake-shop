@extends('admin.layouts.app')

@section('title','Low Stock')

@section('content')

<div class="container-fluid">

<h2 class="mb-4">Low Stock Ingredients</h2>

<table class="table table-bordered">

<thead>
<tr>
<th>Ingredient</th>
<th>Current Stock</th>
</tr>
</thead>

<tbody>

@foreach($items as $item)
<tr>
<td>{{ $item->name }}</td>
<td>{{ $item->stock }}</td>
</tr>
@endforeach

</tbody>

</table>

</div>

@endsection