@extends('admin.layouts.app')

@section('title', 'Orders - Blonde Bakery Admin')

@section('content')

<div class="container-fluid">

<!-- Top Buttons -->

<div class="d-flex gap-2 mb-4">

<a href="{{ route('admin.orders.index') }}" class="btn btn-dark">
All Orders
</a>

<a href="{{ route('admin.orders.index',['type'=>'walkin']) }}" class="btn btn-warning">
Walk-In Orders
</a>

<a href="{{ route('admin.walkin-orders.create') }}" class="btn btn-success">
+ Create Walk-In Order
</a>

</div>


<!-- Filters -->

<div class="card mb-4">
<div class="card-body">

<form method="GET" class="row g-3">

<div class="col-md-3">

<input
type="text"
name="search"
class="form-control"
placeholder="Search Order / Customer / Phone"
value="{{ request('search') }}"
>

</div>


<div class="col-md-2">

<select name="order_source" class="form-select">

<option value="">Order Type</option>

<option value="online"
{{ request('order_source')=='online' ? 'selected' : '' }}>
Online
</option>

<option value="walkin"
{{ request('order_source')=='walkin' ? 'selected' : '' }}>
Walk-In
</option>

</select>

</div>


<div class="col-md-2">

<select name="status" class="form-select">

<option value="">Status</option>

<option value="pending"
{{ request('status')=='pending'?'selected':'' }}>
Pending
</option>

<option value="processing"
{{ request('status')=='processing'?'selected':'' }}>
Processing
</option>

<option value="delivered"
{{ request('status')=='delivered'?'selected':'' }}>
Delivered
</option>

<option value="cancelled"
{{ request('status')=='cancelled'?'selected':'' }}>
Cancelled
</option>

</select>

</div>


<div class="col-md-2">

<select name="payment_method" class="form-select">

<option value="">Payment</option>

<option value="cash"
{{ request('payment_method')=='cash'?'selected':'' }}>
Cash
</option>

<option value="upi"
{{ request('payment_method')=='upi'?'selected':'' }}>
UPI
</option>

<option value="card"
{{ request('payment_method')=='card'?'selected':'' }}>
Card
</option>

</select>

</div>


<div class="col-md-2">

<input
type="date"
name="delivery_date"
class="form-control"
value="{{ request('delivery_date') }}"
>

</div>


<div class="col-md-1 d-grid">

<button class="btn btn-primary">
Filter
</button>

</div>

</form>

</div>
</div>


<!-- Orders Table -->

<div class="table-container">

<div class="table-responsive">
<div style="margin-bottom:15px">
</div>
<table class="table table-hover align-middle">

<thead>

<tr>
<th>ORDER ID</th>
<th>CUSTOMER</th>
<th>PHONE</th>
<th>EMAIL</th>
<th>DELIVERY DATE</th>
<th>ITEMS</th>
<th>TOTAL</th>
<th>STATUS</th>
<th>PAYMENT</th>
<th class="text-end">ACTIONS</th>
</tr>

</thead>


<tbody>

@forelse($orders as $order)

<tr>

<td class="fw-bold">
#{{ $order->id }}
</td>


<td>

{{ $order->customer_name ?? $order->user->name ?? 'Guest' }}

@if($order->order_source == 'walkin')

<span class="badge bg-warning text-dark ms-1">
Walk-In
</span>

@else

<span class="badge bg-primary ms-1">
Online
</span>

@endif

</td>


<td>

@if($order->order_source == 'walkin')

{{ $order->phone ?? '—' }}

@else

{{ $order->user->phone ?? $order->phone ?? '—' }}

@endif

</td>


<td>

@if($order->order_source == 'walkin')

{{ $order->email ?? '—' }}

@else

{{ $order->user->email ?? '—' }}

@endif

</td>


<td>

{{ $order->delivery_date
? \Carbon\Carbon::parse($order->delivery_date)->format('d M Y')
: '—' }}

</td>


<td>

@forelse($order->items as $item)

<div class="small">

{{ $item->product->name ?? 'Product' }}
× {{ $item->quantity }}

@if($item->weight)
<span class="text-muted">
({{ $item->weight }}kg)
</span>
@endif

</div>

@empty

<span class="text-muted fst-italic">
No items
</span>

@endforelse

</td>


<td class="fw-bold">

₹{{ number_format($order->total_amount,2) }}

</td>


<td>

@php
$statusClass = match($order->status) {
'pending' => 'warning',
'processing' => 'info',
'delivered' => 'success',
'cancelled' => 'danger',
default => 'secondary'
};
@endphp

<span class="badge bg-{{ $statusClass }}">
{{ ucfirst($order->status) }}
</span>

</td>


<td>

@if($order->payment_method)

<span class="badge bg-dark">

{{ strtoupper($order->payment_method) }}

</span>

@else

<span class="text-muted">—</span>

@endif

</td>


<td class="text-end">

<div class="btn-group">

<a
href="{{ route('admin.orders.show',$order->id) }}"
class="btn btn-sm btn-outline-info"
title="View"
>
<i class="fas fa-eye"></i>
</a>


<button
class="btn btn-sm btn-outline-secondary dropdown-toggle"
data-bs-toggle="dropdown"
>

<i class="fas fa-edit me-1"></i>Status

</button>


<ul class="dropdown-menu dropdown-menu-end">


<li>

<form action="{{ route('admin.orders.update',$order->id) }}" method="POST">

@csrf
@method('PATCH')

<input type="hidden" name="status" value="processing">

<button type="submit" class="dropdown-item">
Processing
</button>

</form>

</li>


<li>

<form action="{{ route('admin.orders.update',$order->id) }}" method="POST">

@csrf
@method('PATCH')

<input type="hidden" name="status" value="delivered">

<button type="submit" class="dropdown-item">
Delivered
</button>

</form>

</li>


<li>

<form action="{{ route('admin.orders.update',$order->id) }}" method="POST">

@csrf
@method('PATCH')

<input type="hidden" name="status" value="cancelled">

<button type="submit" class="dropdown-item">
Cancelled
</button>

</form>

</li>

</ul>

</div>

</td>

</tr>


@empty

<tr>

<td colspan="10" class="text-center py-5">

<i class="fas fa-inbox fs-2 text-muted mb-3 d-block"></i>

<h5 class="text-muted">
No orders found
</h5>

</td>

</tr>

@endforelse

</tbody>

</table>

</div>


<!-- Pagination -->

<div class="mt-3">

{{ $orders->appends(request()->query())->links() }}

</div>

</div>

</div>

@endsection