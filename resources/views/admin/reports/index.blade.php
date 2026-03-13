@extends('admin.layouts.app')

@section('title', 'Reports & Analytics')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Header with Date Display -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 fw-bold" style="color: var(--gold);">Reports & Analytics</h1>
            <p class="text-muted text-uppercase small tracking-wide">Real-time data from your database</p>
        </div>
        <div class="bg-white px-4 py-2 rounded-pill shadow-sm border">
            <span class="small fw-bold text-dark">
                <i class="far fa-calendar-alt me-2" style="color: var(--gold);"></i>{{ now()->format('l, F j, Y') }}
            </span>
        </div>
    </div>

    <!-- Date Filter Card -->
    <div class="card border-0 shadow-sm mb-5" style="border-radius: 15px;">
        <div class="card-body p-4">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label fw-bold small text-uppercase" style="color: var(--gold);">From</label>
                    <input type="date" id="start_date" value="{{ $startDate }}" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold small text-uppercase" style="color: var(--gold);">To</label>
                    <input type="date" id="end_date" value="{{ $endDate }}" class="form-control">
                </div>
                <div class="col-md-2">
                    <button onclick="applyDateRange()" class="btn btn-gold w-100">
                        <i class="fas fa-calendar-check me-2"></i> Apply
                    </button>
                </div>
                <div class="col-md-4">
                    <div class="d-flex gap-2">
                        <button onclick="quickDate('today')" class="btn btn-outline-gold flex-fill">Today</button>
                        <button onclick="quickDate('week')" class="btn btn-outline-gold flex-fill">This Week</button>
                        <button onclick="quickDate('month')" class="btn btn-outline-gold flex-fill">This Month</button>
                        <button onclick="quickDate('year')" class="btn btn-outline-gold flex-fill">This Year</button>
                        <button onclick="quickDate('all')" class="btn btn-outline-gold flex-fill">All Time</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs Navigation -->
    <ul class="nav nav-tabs mb-4" id="reportTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="sales-tab" data-bs-toggle="tab" data-bs-target="#sales" type="button" role="tab">
                <i class="fas fa-chart-line me-2"></i>Sales & Revenue
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="operations-tab" data-bs-toggle="tab" data-bs-target="#operations" type="button" role="tab">
                <i class="fas fa-clipboard-list me-2"></i>Order & Operations
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="customers-tab" data-bs-toggle="tab" data-bs-target="#customers" type="button" role="tab">
                <i class="fas fa-users me-2"></i>Customer Reports
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="inventory-tab" data-bs-toggle="tab" data-bs-target="#inventory" type="button" role="tab">
                <i class="fas fa-boxes me-2"></i>Inventory Reports
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="financial-tab" data-bs-toggle="tab" data-bs-target="#financial" type="button" role="tab">
                <i class="fas fa-coins me-2"></i>Financial Reports
            </button>
        </li>
    </ul>

    <!-- Loading Spinner -->
    <div id="loading" class="text-center my-5 d-none">
        <div class="spinner-border" style="color: var(--gold);" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <p class="mt-2">Generating report...</p>
    </div>

    <!-- Tab Content -->
    <div class="tab-content" id="reportTabsContent">
        <!-- Sales & Revenue Tab -->
        <div class="tab-pane fade show active" id="sales" role="tabpanel">
            <div class="row g-4">
                @php
                    $salesReports = [
                        ['id' => 'daily-sales', 'title' => 'Daily Sales Report', 'desc' => 'Total orders, revenue, and payment method breakdown for selected date.'],
                        ['id' => 'monthly-sales', 'title' => 'Monthly Sales Overview', 'desc' => 'Monthly revenue, order volume, and month-over-month growth trends.'],
                        ['id' => 'product-sales', 'title' => 'Product-wise Sales', 'desc' => 'Quantity sold and revenue for each product.'],
                        ['id' => 'category-sales', 'title' => 'Category Sales', 'desc' => 'Performance of sales by category with quantity and revenue.'],
                        ['id' => 'top-products', 'title' => 'Top Selling Products', 'desc' => 'Top 10 best-selling products ranked by quantity and revenue.'],
                        ['id' => 'low-products', 'title' => 'Low Selling Products', 'desc' => 'Products with low sales that may need promotion or removal.'],
                    ];
                @endphp
                @foreach($salesReports as $report)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm report-card">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold">{{ $report['title'] }}</h5>
                            <p class="card-text text-muted small flex-grow-1">{{ $report['desc'] }}</p>
                            <button onclick="generateReport('{{ $report['id'] }}')" class="btn btn-outline-gold mt-3 w-100">
                                GENERATE REPORT <i class="fas fa-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Order & Operations Tab -->
        <div class="tab-pane fade" id="operations" role="tabpanel">
            <div class="row g-4">
                @php
                    $opsReports = [
                        ['id' => 'order-summary', 'title' => 'Order Summary', 'desc' => 'Orders grouped by status: pending, confirmed, completed, cancelled.'],
                        ['id' => 'custom-orders', 'title' => 'Custom Cake Orders', 'desc' => 'Custom orders with special instructions.'],
                        ['id' => 'order-type', 'title' => 'Pre-order vs Walk-in', 'desc' => 'Compare online pre-orders with in-store purchases.'],
                        ['id' => 'delivery-orders', 'title' => 'Delivery Orders', 'desc' => 'Delivery orders with addresses and delivery status.'],
                        ['id' => 'pickup-orders', 'title' => 'Pickup Orders', 'desc' => 'In-store pickup orders with scheduled times.'],
                    ];
                @endphp
                @foreach($opsReports as $report)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm report-card">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold">{{ $report['title'] }}</h5>
                            <p class="card-text text-muted small flex-grow-1">{{ $report['desc'] }}</p>
                            <button onclick="generateReport('{{ $report['id'] }}')" class="btn btn-outline-gold mt-3 w-100">
                                GENERATE REPORT <i class="fas fa-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Customer Reports Tab -->
        <div class="tab-pane fade" id="customers" role="tabpanel">
            <div class="row g-4">
                @php
                    $customerReports = [
                        ['id' => 'top-customers', 'title' => 'Top Customers', 'desc' => 'Best customers by spending and order frequency.'],
                        ['id' => 'customer-history', 'title' => 'Customer History', 'desc' => 'Complete order history for individual customers.'],
                        ['id' => 'new-returning', 'title' => 'New vs Returning', 'desc' => 'Compare new customers with returning customers.'],
                        ['id' => 'customer-frequency', 'title' => 'Order Frequency', 'desc' => 'How often customers place orders (weekly, monthly).'],
                    ];
                @endphp
                @foreach($customerReports as $report)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm report-card">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold">{{ $report['title'] }}</h5>
                            <p class="card-text text-muted small flex-grow-1">{{ $report['desc'] }}</p>
                            <button onclick="generateReport('{{ $report['id'] }}')" class="btn btn-outline-gold mt-3 w-100">
                                GENERATE REPORT <i class="fas fa-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Inventory Reports Tab -->
        <div class="tab-pane fade" id="inventory" role="tabpanel">
            <div class="row g-4">
                @php
                    $inventoryReports = [
                        ['id' => 'material-usage', 'title' => 'Raw Material Usage', 'desc' => 'Track consumption of flour, sugar, cream, chocolate.'],
                        ['id' => 'low-stock', 'title' => 'Low Stock Alert', 'desc' => 'Ingredients and products running low in inventory.'],
                        ['id' => 'stock-movement', 'title' => 'Stock Movement', 'desc' => 'All inventory transactions: stock added, used, wasted.'],
                    ];
                @endphp
                @foreach($inventoryReports as $report)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm report-card">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold">{{ $report['title'] }}</h5>
                            <p class="card-text text-muted small flex-grow-1">{{ $report['desc'] }}</p>
                            <button onclick="generateReport('{{ $report['id'] }}')" class="btn btn-outline-gold mt-3 w-100">
                                GENERATE REPORT <i class="fas fa-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Financial Reports Tab -->
        <div class="tab-pane fade" id="financial" role="tabpanel">
            <div class="row g-4">
                @php
                    $financialReports = [
                        ['id' => 'profit-margin', 'title' => 'Profit Margin', 'desc' => 'Profit margins for each product with cost analysis.'],
                        ['id' => 'discount-report', 'title' => 'Discount Impact', 'desc' => 'Revenue impact of discounts and coupons.'],
                        ['id' => 'payment-methods', 'title' => 'Payment Methods', 'desc' => 'Revenue distribution by payment type.'],
                    ];
                @endphp
                @foreach($financialReports as $report)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm report-card">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold">{{ $report['title'] }}</h5>
                            <p class="card-text text-muted small flex-grow-1">{{ $report['desc'] }}</p>
                            <button onclick="generateReport('{{ $report['id'] }}')" class="btn btn-outline-gold mt-3 w-100">
                                GENERATE REPORT <i class="fas fa-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Report Output Area -->
    <div id="report-output" class="mt-5 d-none">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center py-3">
                <h4 class="serif mb-0" id="report-title">Report</h4>
            <div class="report-actions">

            <a href="{{ url('/admin/reports/export/pdf') }}" class="btn btn-danger">
            PDF
            </a>

            <a href="{{ url('/admin/reports/export/excel') }}" class="btn btn-success">
            Excel
            </a>

            </div>
            </div>
            <div class="card-body" id="report-content">
                <div class="text-center py-5 text-muted">
                    <i class="fas fa-chart-pie fa-3x mb-3" style="color: var(--gold);"></i>
                    <p class="serif h5">Select a report to generate</p>
                    <p class="small">Real-time data from your database will appear here</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let currentReportType = null;

function quickDate(period) {
    const today = new Date();
    let startDate, endDate;

    switch(period) {
        case 'today':
            startDate = formatDate(today);
            endDate = formatDate(today);
            break;
        case 'week':
            const firstDay = new Date(today.setDate(today.getDate() - today.getDay()));
            startDate = formatDate(firstDay);
            endDate = formatDate(new Date());
            break;
        case 'month':
            startDate = formatDate(new Date(today.getFullYear(), today.getMonth(), 1));
            endDate = formatDate(new Date());
            break;
        case 'year':
            startDate = formatDate(new Date(today.getFullYear(), 0, 1));
            endDate = formatDate(new Date());
            break;
        case 'all':
            startDate = '2000-01-01';
            endDate = formatDate(new Date());
            break;
    }

    document.getElementById('start_date').value = startDate;
    document.getElementById('end_date').value = endDate;
}

function formatDate(date) {
    return date.toISOString().split('T')[0];
}

function applyDateRange() {
    if (currentReportType) {
        generateReport(currentReportType);
    }
}

async function generateReport(reportType) {
    currentReportType = reportType;

    const startDate = document.getElementById('start_date').value;
    const endDate = document.getElementById('end_date').value;

    if (!startDate || !endDate) {
        alert('Please select date range');
        return;
    }

    document.getElementById('loading').classList.remove('d-none');
    document.getElementById('report-output').classList.remove('d-none');

    const titles = {
        'daily-sales': 'Daily Sales Report',
        'monthly-sales': 'Monthly Sales Overview',
        'product-sales': 'Product-wise Sales Report',
        'category-sales': 'Category Sales Report',
        'top-products': 'Top Selling Products',
        'low-products': 'Low Selling Products',
        'order-summary': 'Order Summary Report',
        'custom-orders': 'Custom Cake Orders',
        'order-type': 'Pre-order vs Walk-in',
        'delivery-orders': 'Delivery Orders Report',
        'pickup-orders': 'Pickup Orders Report',
        'top-customers': 'Top Customers Report',
        'customer-history': 'Customer Order History',
        'new-returning': 'New vs Returning Customers',
        'customer-frequency': 'Customer Frequency Report',
        'material-usage': 'Raw Material Usage',
        'low-stock': 'Low Stock Alert',
        'stock-movement': 'Stock Movement Report',
        'profit-margin': 'Profit Margin Report',
        'discount-report': 'Discount Impact Report',
        'payment-methods': 'Payment Method Report'
    };

    document.getElementById('report-title').innerText = titles[reportType] || 'Report';

    try {
        const url = `/admin/reports/${reportType}?start_date=${startDate}&end_date=${endDate}`;
        const response = await fetch(url);

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const result = await response.json();

        if (result.success) {
            displayReportData(reportType, result.data);
        } else {
            throw new Error(result.message || 'Failed to generate report');
        }
    } catch (error) {
        document.getElementById('report-content').innerHTML = `
            <div class="text-center py-5 text-danger">
                <i class="fas fa-exclamation-circle fa-3x mb-3"></i>
                <p class="h5">Error generating report</p>
                <p class="small">${error.message}</p>
                <button onclick="generateReport('${reportType}')" class="btn btn-gold mt-3">Try Again</button>
            </div>
        `;
    } finally {
        document.getElementById('loading').classList.add('d-none');
    }
}

function displayReportData(reportType, data) {
    let html = '';

    switch(reportType) {
        case 'daily-sales':
            html = displayDailySales(data);
            break;
        case 'monthly-sales':
            html = displayMonthlySales(data);
            break;
        case 'product-sales':
            html = displayProductSales(data);
            break;
        case 'category-sales':
            html = displayCategorySales(data);
            break;
        case 'top-products':
            html = displayTopProducts(data);
            break;
        case 'low-products':
            html = displayLowProducts(data);
            break;
        case 'order-summary':
            html = displayOrderSummary(data);
            break;
        case 'custom-orders':
            html = displayCustomOrders(data);
            break;
        case 'order-type':
            html = displayOrderType(data);
            break;
        case 'delivery-orders':
            html = displayDeliveryOrders(data);
            break;
        case 'pickup-orders':
            html = displayPickupOrders(data);
            break;
        case 'top-customers':
            html = displayTopCustomers(data);
            break;
        case 'customer-history':
            html = displayCustomerHistory(data);
            break;
        case 'new-returning':
            html = displayNewReturning(data);
            break;
        case 'customer-frequency':
            html = displayCustomerFrequency(data);
            break;
        case 'material-usage':
            html = displayMaterialUsage(data);
            break;
        case 'low-stock':
            html = displayLowStock(data);
            break;
        case 'stock-movement':
            html = displayStockMovement(data);
            break;
        case 'profit-margin':
            html = displayProfitMargin(data);
            break;
        case 'discount-report':
            html = displayDiscountReport(data);
            break;
        case 'payment-methods':
            html = displayPaymentMethods(data);
            break;
        default:
            html = `<pre class="bg-light p-3 rounded">${JSON.stringify(data, null, 2)}</pre>`;
    }

    document.getElementById('report-content').innerHTML = html;
}

function displayDailySales(data) {
    return `
        <div class="row g-4 mb-4">
            <div class="col-md-4"><div class="bg-light p-3 rounded border-start border-3" style="border-color: var(--gold);"><small class="text-muted">Total Orders</small><h3 class="serif">${data.summary.total_orders}</h3></div></div>
            <div class="col-md-4"><div class="bg-light p-3 rounded border-start border-3" style="border-color: var(--gold);"><small class="text-muted">Total Revenue</small><h3 class="serif text-gold">₹${data.summary.total_revenue.toLocaleString()}</h3></div></div>
            <div class="col-md-4"><div class="bg-light p-3 rounded border-start border-3" style="border-color: var(--gold);"><small class="text-muted">Average Order</small><h3 class="serif">₹${data.summary.average_order_value.toLocaleString()}</h3></div></div>
        </div>
        <h6 class="fw-bold mb-3">Payment Method Breakdown</h6>
        <table class="table table-sm table-bordered">
            <thead class="table-light"><tr><th>Method</th><th class="text-end">Orders</th><th class="text-end">Revenue</th></tr></thead>
            <tbody>${data.payment_breakdown.length ? data.payment_breakdown.map(m => `<tr><td>${m.payment_method || 'N/A'}</td><td class="text-end">${m.order_count}</td><td class="text-end text-gold fw-bold">₹${m.revenue.toLocaleString()}</td></tr>`).join('') : '<tr><td colspan="3" class="text-center">No data</td></tr>'}</tbody>
        </table>
        <h6 class="fw-bold mb-3 mt-4">Orders by Status</h6>
        <table class="table table-sm table-bordered">
            <thead class="table-light"><tr><th>Status</th><th class="text-end">Orders</th><th class="text-end">Revenue</th></tr></thead>
            <tbody>${data.orders_by_status.length ? data.orders_by_status.map(s => `<tr><td><span class="badge bg-${s.status === 'pending' ? 'warning' : s.status === 'processing' ? 'info' : s.status === 'completed' ? 'success' : 'danger'} text-dark">${s.status}</span></td><td class="text-end">${s.count}</td><td class="text-end text-gold fw-bold">₹${s.revenue.toLocaleString()}</td></tr>`).join('') : '<tr><td colspan="3" class="text-center">No orders</td></tr>'}</tbody>
        </table>
    `;
}

function displayMonthlySales(data) {
    return `
        <div class="row g-4 mb-4">
            <div class="col-md-3"><div class="bg-light p-3 rounded"><small>Orders</small><h4>${data.current_month.total_orders}</h4></div></div>
            <div class="col-md-3"><div class="bg-light p-3 rounded"><small>Revenue</small><h4 class="text-gold">₹${data.current_month.total_revenue.toLocaleString()}</h4></div></div>
            <div class="col-md-3"><div class="bg-light p-3 rounded"><small>Average</small><h4>₹${Math.round(data.current_month.average_order).toLocaleString()}</h4></div></div>
            <div class="col-md-3"><div class="bg-light p-3 rounded"><small>Growth</small><h4 class="${data.growth_percentage >= 0 ? 'text-success' : 'text-danger'}">${data.growth_percentage >= 0 ? '+' : ''}${data.growth_percentage}%</h4></div></div>
        </div>
        <h6 class="fw-bold mb-3">Daily Trend</h6>
        <div class="table-responsive"><table class="table table-sm table-bordered"><thead class="table-light"><tr><th>Date</th><th class="text-end">Orders</th><th class="text-end">Revenue</th></tr></thead><tbody>${data.daily_trend.map(d => `<tr><td>${d.date}</td><td class="text-end">${d.orders}</td><td class="text-end text-gold">₹${d.revenue.toLocaleString()}</td></tr>`).join('')}</tbody></table></div>
    `;
}

function displayProductSales(data) {
    if (!data.length) return '<p class="text-center">No data</p>';
    return `<div class="table-responsive"><table class="table table-sm table-bordered"><thead class="table-light"><tr><th>Product</th><th>Category</th><th class="text-end">Qty</th><th class="text-end">Revenue</th><th class="text-end">Avg Price</th></tr></thead><tbody>${data.map(p => `<tr><td>${p.product_name}</td><td>${p.category}</td><td class="text-end">${p.quantity_sold}</td><td class="text-end text-gold fw-bold">₹${p.revenue.toLocaleString()}</td><td class="text-end">₹${p.avg_price.toLocaleString()}</td></tr>`).join('')}</tbody></table></div>`;
}

function displayCategorySales(data) {
    if (!data.length) return '<p class="text-center">No data</p>';
    return `<div class="table-responsive"><table class="table table-sm table-bordered"><thead class="table-light"><tr><th>Category</th><th class="text-end">Products</th><th class="text-end">Qty</th><th class="text-end">Revenue</th></tr></thead><tbody>${data.map(c => `<tr><td>${c.category_name}</td><td class="text-end">${c.product_count}</td><td class="text-end">${c.total_quantity}</td><td class="text-end text-gold fw-bold">₹${c.total_revenue.toLocaleString()}</td></tr>`).join('')}</tbody></table></div>`;
}

function displayTopProducts(data) {
    if (!data.length) return '<p class="text-center">No data</p>';
    return `<div class="table-responsive"><table class="table table-sm table-bordered"><thead class="table-light"><tr><th>Rank</th><th>Product</th><th>Category</th><th class="text-end">Qty</th><th class="text-end">Revenue</th></tr></thead><tbody>${data.map(p => `<tr><td><span class="badge bg-gold">#${p.rank}</span></td><td>${p.product_name}</td><td>${p.category}</td><td class="text-end">${p.quantity_sold}</td><td class="text-end text-gold fw-bold">₹${p.revenue.toLocaleString()}</td></tr>`).join('')}</tbody></table></div>`;
}

function displayLowProducts(data) {
    if (!data.length) return '<p class="text-center">No low products</p>';
    return `<div class="table-responsive"><table class="table table-sm table-bordered"><thead class="table-light"><tr><th>Product</th><th>Category</th><th class="text-end">Sold</th><th class="text-end">Price</th><th>Status</th></tr></thead><tbody>${data.map(p => `<tr><td>${p.product_name}</td><td>${p.category}</td><td class="text-end">${p.quantity_sold}</td><td class="text-end text-gold">₹${p.price.toLocaleString()}</td><td><span class="badge bg-${p.status === 'No Sales' ? 'danger' : 'warning'}">${p.status}</span></td></tr>`).join('')}</tbody></table></div>`;
}

function displayOrderSummary(data) {
    return `
        <div class="row g-4 mb-4">
            <div class="col-md-6"><div class="bg-light p-3 rounded"><small>Total Orders</small><h3>${data.summary.total_orders}</h3></div></div>
            <div class="col-md-6"><div class="bg-light p-3 rounded"><small>Total Value</small><h3 class="text-gold">₹${data.summary.total_value.toLocaleString()}</h3></div></div>
        </div>
        <table class="table table-sm table-bordered"><thead class="table-light"><tr><th>Status</th><th class="text-end">Orders</th><th class="text-end">Value</th><th class="text-end">%</th></tr></thead><tbody>${data.data.map(s => `<tr><td><span class="badge bg-${s.status === 'pending' ? 'warning' : s.status === 'processing' ? 'info' : s.status === 'completed' ? 'success' : 'danger'}">${s.status}</span></td><td class="text-end">${s.order_count}</td><td class="text-end text-gold fw-bold">₹${s.total_value.toLocaleString()}</td><td class="text-end">${((s.total_value / data.summary.total_value) * 100).toFixed(1)}%</td></tr>`).join('')}</tbody></table>
    `;
}

function displayCustomOrders(data) {
    if (!data.length) return '<p class="text-center">No custom orders</p>';
    return `<div class="table-responsive"><table class="table table-sm table-bordered"><thead class="table-light"><tr><th>Order #</th><th>Customer</th><th>Message</th><th>Instructions</th><th class="text-end">Amount</th><th>Status</th></tr></thead><tbody>${data.map(o => `<tr><td>${o.order_number}</td><td>${o.customer_name}</td><td><small>${o.cake_message || '-'}</small></td><td><small>${o.special_instructions || '-'}</small></td><td class="text-end text-gold fw-bold">₹${o.total_amount.toLocaleString()}</td><td><span class="badge bg-${o.status === 'pending' ? 'warning' : o.status === 'processing' ? 'info' : 'success'}">${o.status}</span></td></tr>`).join('')}</tbody></table></div>`;
}

function displayOrderType(data) {
    return `
        <div class="row g-4">
            <div class="col-md-6"><div class="bg-light p-4 rounded border-start border-3 border-info"><h5 class="text-info">Pre-orders</h5><p class="mb-1">Orders: ${data.pre_orders.count}</p><p class="mb-1">Revenue: <span class="text-gold">₹${data.pre_orders.revenue.toLocaleString()}</span></p><p>Avg: ₹${data.pre_orders.average.toLocaleString()}</p></div></div>
            <div class="col-md-6"><div class="bg-light p-4 rounded border-start border-3 border-success"><h5 class="text-success">Walk-in</h5><p class="mb-1">Orders: ${data.walk_in.count}</p><p class="mb-1">Revenue: <span class="text-gold">₹${data.walk_in.revenue.toLocaleString()}</span></p><p>Avg: ₹${data.walk_in.average.toLocaleString()}</p></div></div>
        </div>
    `;
}

function displayDeliveryOrders(data) { return `<pre>${JSON.stringify(data, null, 2)}</pre>`; }
function displayPickupOrders(data) { return `<pre>${JSON.stringify(data, null, 2)}</pre>`; }

function displayTopCustomers(data) {
    if (!data.length) return '<p class="text-center">No customers</p>';
    return `<div class="table-responsive"><table class="table table-sm table-bordered"><thead class="table-light"><tr><th>Rank</th><th>Customer</th><th>Email</th><th class="text-end">Orders</th><th class="text-end">Spent</th><th class="text-end">Avg</th></tr></thead><tbody>${data.map(c => `<tr><td><span class="badge bg-gold">#${c.rank}</span></td><td>${c.name}</td><td>${c.email}</td><td class="text-end">${c.total_orders}</td><td class="text-end text-gold fw-bold">₹${c.total_spent.toLocaleString()}</td><td class="text-end">₹${c.average_order.toLocaleString()}</td></tr>`).join('')}</tbody></table></div>`;
}

function displayCustomerHistory(data) {
    return `
        <div class="bg-light p-3 rounded mb-4"><h6>Customer: ${data.customer.name}</h6><p class="mb-1">Email: ${data.customer.email} | Phone: ${data.customer.phone} | Member since: ${data.customer.member_since}</p></div>
        <div class="row g-3 mb-4">
            <div class="col-md-4"><div class="bg-light p-3 rounded text-center"><small>Orders</small><h4>${data.summary.total_orders}</h4></div></div>
            <div class="col-md-4"><div class="bg-light p-3 rounded text-center"><small>Spent</small><h4 class="text-gold">₹${data.summary.total_spent.toLocaleString()}</h4></div></div>
            <div class="col-md-4"><div class="bg-light p-3 rounded text-center"><small>Avg</small><h4>₹${data.summary.average_order.toLocaleString()}</h4></div></div>
        </div>
        <h6>Order History</h6>
        <table class="table table-sm table-bordered"><thead class="table-light"><tr><th>Order #</th><th>Date</th><th class="text-end">Amount</th><th>Status</th><th>Payment</th></tr></thead><tbody>${data.orders.map(o => `<tr><td>${o.order_number}</td><td>${o.date}</td><td class="text-end text-gold fw-bold">₹${o.total.toLocaleString()}</td><td><span class="badge bg-${o.status === 'pending' ? 'warning' : o.status === 'processing' ? 'info' : 'success'}">${o.status}</span></td><td>${o.payment_method}</td></tr>`).join('')}</tbody></table>
    `;
}

function displayNewReturning(data) {
    return `
        <div class="row g-4">
            <div class="col-md-6"><div class="bg-light p-4 rounded border-start border-3 border-success"><h5 class="text-success">New Customers</h5><p class="mb-1">Count: ${data.new.customer_count}</p><p class="mb-1">Revenue: <span class="text-gold">₹${data.new.revenue.toLocaleString()}</span></p><p>Percentage: ${data.new.percentage}%</p></div></div>
            <div class="col-md-6"><div class="bg-light p-4 rounded border-start border-3 border-info"><h5 class="text-info">Returning Customers</h5><p class="mb-1">Count: ${data.returning.customer_count}</p><p class="mb-1">Revenue: <span class="text-gold">₹${data.returning.revenue.toLocaleString()}</span></p><p>Percentage: ${data.returning.percentage}%</p></div></div>
        </div>
    `;
}

function displayCustomerFrequency(data) {
    return `
        <div class="row g-3">
            <div class="col-md-2 col-4"><div class="bg-light p-3 rounded text-center"><div class="bg-purple-light rounded-circle mx-auto mb-2" style="width:40px;height:40px;line-height:40px"><i class="fas fa-calendar-week text-purple"></i></div><h5>${data.weekly}</h5><small>Weekly</small></div></div>
            <div class="col-md-2 col-4"><div class="bg-light p-3 rounded text-center"><div class="bg-blue-light rounded-circle mx-auto mb-2" style="width:40px;height:40px;line-height:40px"><i class="fas fa-calendar text-blue"></i></div><h5>${data.monthly}</h5><small>Monthly</small></div></div>
            <div class="col-md-2 col-4"><div class="bg-light p-3 rounded text-center"><div class="bg-green-light rounded-circle mx-auto mb-2" style="width:40px;height:40px;line-height:40px"><i class="fas fa-calendar-alt text-green"></i></div><h5>${data.quarterly}</h5><small>Quarterly</small></div></div>
            <div class="col-md-2 col-4"><div class="bg-light p-3 rounded text-center"><div class="bg-amber-light rounded-circle mx-auto mb-2" style="width:40px;height:40px;line-height:40px"><i class="fas fa-calendar-plus text-amber"></i></div><h5>${data.yearly}</h5><small>Yearly</small></div></div>
            <div class="col-md-2 col-4"><div class="bg-light p-3 rounded text-center"><div class="bg-gray-light rounded-circle mx-auto mb-2" style="width:40px;height:40px;line-height:40px"><i class="fas fa-user text-gray"></i></div><h5>${data.one_time}</h5><small>One-time</small></div></div>
        </div>
    `;
}

function displayMaterialUsage(data) {
    return `
        <div class="row g-3">
            <div class="col-md-4"><div class="bg-light p-3 rounded"><small>Flour</small><h5>${data.flour} g</h5><small class="text-muted">${(data.flour/1000).toFixed(2)} kg</small></div></div>
            <div class="col-md-4"><div class="bg-light p-3 rounded"><small>Sugar</small><h5>${data.sugar} g</h5><small class="text-muted">${(data.sugar/1000).toFixed(2)} kg</small></div></div>
            <div class="col-md-4"><div class="bg-light p-3 rounded"><small>Cream</small><h5>${data.cream} ml</h5><small class="text-muted">${(data.cream/1000).toFixed(2)} L</small></div></div>
            <div class="col-md-4"><div class="bg-light p-3 rounded"><small>Chocolate</small><h5>${data.chocolate} g</h5><small class="text-muted">${(data.chocolate/1000).toFixed(2)} kg</small></div></div>
            <div class="col-md-4"><div class="bg-light p-3 rounded"><small>Butter</small><h5>${data.butter} g</h5><small class="text-muted">${(data.butter/1000).toFixed(2)} kg</small></div></div>
            <div class="col-md-4"><div class="bg-light p-3 rounded"><small>Eggs</small><h5>${data.eggs}</h5><small class="text-muted">units</small></div></div>
        </div>
    `;
}

function displayLowStock(data) {
    if (!data.length) return '<p class="text-center">No low stock items</p>';
    return `<div class="table-responsive"><table class="table table-sm table-bordered"><thead class="table-light"><tr><th>Product</th><th class="text-end">Stock</th><th class="text-end">Reorder Level</th><th class="text-end">Suggested Order</th></tr></thead><tbody>${data.map(i => `<tr><td>${i.product_name}</td><td class="text-end ${i.current_stock < 5 ? 'text-danger fw-bold' : ''}">${i.current_stock}</td><td class="text-end">${i.reorder_level}</td><td class="text-end text-gold fw-bold">${i.suggested_order}</td></tr>`).join('')}</tbody></table></div>`;
}

function displayStockMovement(data) {
    return `
        <div class="row g-3">
            <div class="col-md-3"><div class="bg-light p-3 rounded text-center"><small>Added</small><h4 class="text-success">+${data.added}</h4></div></div>
            <div class="col-md-3"><div class="bg-light p-3 rounded text-center"><small>Used</small><h4 class="text-primary">-${data.used}</h4></div></div>
            <div class="col-md-3"><div class="bg-light p-3 rounded text-center"><small>Wasted</small><h4 class="text-danger">-${data.wasted}</h4></div></div>
            <div class="col-md-3"><div class="bg-light p-3 rounded text-center"><small>Net</small><h4 class="${data.net_change >= 0 ? 'text-success' : 'text-danger'}">${data.net_change >= 0 ? '+' : ''}${data.net_change}</h4></div></div>
        </div>
    `;
}

function displayProfitMargin(data) {
    if (!data.length) return '<p class="text-center">No data</p>';
    return `
        <div class="table-responsive">
            <table class="table table-sm table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Product</th>
                        <th class="text-end">Price</th>
                        <th class="text-end">Cost</th>
                        <th class="text-end">Qty</th>
                        <th class="text-end">Revenue</th>
                        <th class="text-end">Profit</th>
                        <th class="text-end">Margin %</th>
                    </tr>
                </thead>
                <tbody>
                    ${data.map(p => {
                        const profit = p.revenue - p.cost_total;
                        const margin = p.revenue > 0 ? ((profit / p.revenue) * 100).toFixed(2) : 0;
                        return `<tr>
                            <td>${p.product_name}</td>
                            <td class="text-end">₹${p.price.toLocaleString()}</td>
                            <td class="text-end">₹${p.cost_total.toLocaleString()}</td>
                            <td class="text-end">${p.quantity}</td>
                            <td class="text-end text-gold fw-bold">₹${p.revenue.toLocaleString()}</td>
                            <td class="text-end">₹${profit.toLocaleString()}</td>
                            <td class="text-end">${margin}%</td>
                        </tr>`;
                    }).join('')}
                </tbody>
            </table>
        </div>
    `;
}

function displayDiscountReport(data) {
    return `
        <div class="row g-3">
            <div class="col-md-4"><div class="bg-light p-3 rounded text-center"><small>Total Orders</small><h4>${data.total_orders}</h4></div></div>
            <div class="col-md-4"><div class="bg-light p-3 rounded text-center"><small>Discounted Orders</small><h4 class="text-warning">${data.discounted_orders}</h4></div></div>
            <div class="col-md-4"><div class="bg-light p-3 rounded text-center"><small>Total Discount</small><h4 class="text-danger">₹${data.total_discount_given.toLocaleString()}</h4></div></div>
            <div class="col-md-6"><div class="bg-light p-3 rounded"><small>Average Discount</small><h4 class="text-gold">₹${data.average_discount.toLocaleString()}</h4></div></div>
            <div class="col-md-6"><div class="bg-light p-3 rounded"><small>Revenue Impact</small><h4 class="text-gold">${data.revenue_impact}%</h4></div></div>
        </div>
    `;
}

function displayPaymentMethods(data) {
    if (!data.length) return '<p class="text-center">No data</p>';
    return `<div class="table-responsive"><table class="table table-sm table-bordered"><thead class="table-light"><tr><th>Method</th><th class="text-end">Orders</th><th class="text-end">Revenue</th><th class="text-end">%</th></tr></thead><tbody>${data.map(m => `<tr><td>${m.payment_method}</td><td class="text-end">${m.order_count}</td><td class="text-end text-gold fw-bold">₹${m.revenue.toLocaleString()}</td><td class="text-end"><span class="badge bg-info">${m.percentage}%</span></td></tr>`).join('')}</tbody></table></div>`;
}

async function exportReport(format) {
    if (!currentReportType) {
        alert('Please generate a report first');
        return;
    }
    const startDate = document.getElementById('start_date').value;
    const endDate = document.getElementById('end_date').value;
    window.open(`{{ url('admin/reports/export-${format}') }}?report_type=${currentReportType}&start_date=${startDate}&end_date=${endDate}`, '_blank');
}
</script>
@endpush

@push('styles')
<style>
    .report-card { transition: all 0.3s; }
    .report-card:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important; }
    .text-gold { color: var(--gold); }
    .bg-gold { background-color: var(--gold); color: var(--dark); }
    .btn-outline-gold { border: 2px solid var(--gold); color: var(--dark); background: transparent; }
    .btn-outline-gold:hover { background: var(--gold); color: var(--dark); }
    .border-gold { border-color: var(--gold) !important; }
    .bg-purple-light { background-color: #e9d5ff; }
    .bg-blue-light { background-color: #dbeafe; }
    .bg-green-light { background-color: #dcfce7; }
    .bg-amber-light { background-color: #fef3c7; }
    .bg-gray-light { background-color: #f3f4f6; }
    .text-purple { color: #a855f7; }
    .text-blue { color: #3b82f6; }
    .text-green { color: #22c55e; }
    .text-amber { color: #f59e0b; }
    .text-gray { color: #6b7280; }
</style>
@endpush