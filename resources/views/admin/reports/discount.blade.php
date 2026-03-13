@extends('admin.layouts.app')

@section('title','Discount Report')

@section('content')

<div class="container-fluid">

<h2 class="mb-4">Discount & Coupon Report</h2>

<table class="table table-bordered">

<thead>
<tr>
<th>Coupon</th>
<th>Orders</th>
<th>Total Discount</th>
</tr>
</thead>

<tbody>

@foreach($coupons as $coupon)
<tr>
<td>{{ $coupon->code }}</td>
<td>{{ $coupon->orders }}</td>
<td>₹{{ $coupon->discount }}</td>
</tr>
@endforeach

</tbody>

</table>

</div>

@endsection