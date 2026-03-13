@extends('admin.layouts.app')

@section('title','Stock Movement')

@section('content')

<div class="container-fluid">

<h2 class="mb-4">Stock Movement</h2>

<table class="table table-bordered">

<thead>
<tr>
<th>Ingredient</th>
<th>Added</th>
<th>Used</th>
<th>Waste</th>
</tr>
</thead>

<tbody>

@foreach($items as $item)
<tr>
<td>{{ $item->name }}</td>
<td>{{ $item->added }}</td>
<td>{{ $item->used }}</td>
<td>{{ $item->waste }}</td>
</tr>
@endforeach

</tbody>

</table>

</div>

@endsection