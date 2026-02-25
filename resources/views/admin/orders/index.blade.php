@extends('admin.layouts.app')

@section('title', 'Orders - Blonde Bakery Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0 fw-bold">Orders</h1>
        <p class="text-muted">Manage customer orders</p>
    </div>
</div>

<div class="table-container">
    <div class="d-flex justify-content-between mb-4">
        <div class="d-flex gap-3">
            <input type="text" id="searchInput" class="form-control" placeholder="Search orders..." style="width: 250px;">
            <select id="statusFilter" class="form-select" style="width: 180px;">
                <option value="">All Statuses</option>
                <option value="pending">Pending</option>
                <option value="processing">Processing</option>
                <option value="delivered">Delivered</option>
                <option value="cancelled">Cancelled</option>
            </select>
            <input type="date" id="dateFrom" class="form-control" style="width: 150px;" placeholder="From">
            <input type="date" id="dateTo" class="form-control" style="width: 150px;" placeholder="To">
            <button class="btn btn-outline-secondary" onclick="filterOrders()">Filter</button>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>ORDER ID</th>
                    <th>CUSTOMER</th>
                    <th>EMAIL</th>
                    <th>PHONE</th>
                    <th>DELIVERY DATE</th>
                    <th>ITEMS</th>
                    <th>TOTAL</th>
                    <th>STATUS</th>
                    <th class="text-end">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td class="fw-medium">#{{ $order->id }}</td>
                    <td>{{ $order->name ?? $order->user->name ?? 'Guest' }}</td>
                    <td>{{ $order->email }}</td>
                    <td>{{ $order->phone }}</td>
                    <td>{{ $order->delivery_date ? \Carbon\Carbon::parse($order->delivery_date)->format('d M Y') : '—' }}</td>
                    <td>
                        @foreach($order->items as $item)
                            <div>{{ $item->product->name ?? 'Product' }} x{{ $item->quantity }} ({{ $item->weight }}kg)</div>
                        @endforeach
                    </td>
                    <td class="fw-bold">₹{{ number_format($order->total_amount, 2) }}</td>
                    <td>
                        @php
                            $statusClass = match($order->status) {
                                'pending' => 'bg-warning text-dark',
                                'processing' => 'bg-info text-dark',
                                'delivered' => 'bg-success',
                                'cancelled' => 'bg-danger',
                                default => 'bg-secondary'
                            };
                        @endphp
                        <span class="badge {{ $statusClass }} px-3 py-2 rounded-pill">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td class="text-end">
                        <div class="btn-group">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                Status
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="processing">
                                        <button type="submit" class="dropdown-item">Processing</button>
                                    </form>
                                </li>
                                <li>
                                    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="delivered">
                                        <button type="submit" class="dropdown-item">Delivered</button>
                                    </form>
                                </li>
                                <li>
                                    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="cancelled">
                                        <button type="submit" class="dropdown-item">Cancelled</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-5">
                        <i class="fas fa-inbox fs-2 text-muted mb-3 d-block"></i>
                        <h5 class="text-muted">No orders found</h5>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    function filterOrders() {
        let search = document.getElementById('searchInput').value.toLowerCase();
        let status = document.getElementById('statusFilter').value.toLowerCase();
        let fromDate = document.getElementById('dateFrom').value;
        let toDate = document.getElementById('dateTo').value;
        let rows = document.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
            let show = true;
            let text = row.innerText.toLowerCase();
            let rowStatus = row.querySelector('td:nth-child(8) span')?.innerText.toLowerCase() || '';
            
            if (search && !text.includes(search)) show = false;
            if (status && rowStatus !== status) show = false;
            
            row.style.display = show ? '' : 'none';
        });
    }

    document.getElementById('searchInput').addEventListener('keyup', filterOrders);
    document.getElementById('statusFilter').addEventListener('change', filterOrders);
</script>
@endsection