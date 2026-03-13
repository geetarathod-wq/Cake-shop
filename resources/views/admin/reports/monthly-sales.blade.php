<!-- resources/views/admin/reports/monthly.blade.php -->

@extends('admin.layouts.app') <!-- or your admin layout -->

@section('title', 'Monthly Sales Overview')

@section('content')
<div class="container">
    <h1>Monthly Sales Overview</h1>

    @if(isset($sales) && count($sales) > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity Sold</th>
                    <th>Revenue</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sales as $item)
                    <tr>
                        <td>{{ $item->product_name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->revenue }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No data available for the selected period.</p>
    @endif
</div>
@endsection