@extends('admin.layouts.app')

@section('title','Inventory Usage')

@section('content')

<div class="container-fluid">

<h2 class="mb-4">Raw Material Usage</h2>

<table class="table table-bordered">

<thead>
<tr>
<th>Ingredient</th>
<th>Used Quantity</th>
</tr>
</thead>

<tbody>

@foreach($ingredients as $item)
<tr>
<td>{{ $item->name }}</td>
<td>{{ $item->used }}</td>
</tr>
@endforeach

</tbody>

</table>

</div>

@endsection