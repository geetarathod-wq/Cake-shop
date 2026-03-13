@extends('admin.layouts.app')

@section('title','Payment Methods')

@section('content')

<div class="container-fluid">

<h2 class="mb-4">Payment Methods Report</h2>

<table class="table table-bordered">

<thead>
<tr>
<th>Method</th>
<th>Total Revenue</th>
</tr>
</thead>

<tbody>

@foreach($methods as $method)
<tr>
<td>{{ ucfirst($method->payment_method) }}</td>
<td>₹{{ number_format($method->revenue,2) }}</td>
</tr>
@endforeach

</tbody>

</table>

</div>

@endsection