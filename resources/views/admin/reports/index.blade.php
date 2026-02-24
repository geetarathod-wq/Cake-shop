@extends('admin.layouts.app')

@section('title', 'Reports & Analytics | Blonde Bakery')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Page Header with Date Range -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 fw-bold mb-1" style="background: linear-gradient(135deg, var(--dark), var(--gold)); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Reports & Analytics</h1>
            <p class="text-muted">Last 30 days performance overview</p>
        </div>
        <div class="d-flex gap-2">
            <div class="input-group" style="max-width: 280px;">
                <span class="input-group-text bg-white border-end-0"><i class="far fa-calendar-alt"></i></span>
                <input type="text" class="form-control border-start-0" placeholder="Oct 1, 2025 – Oct 31, 2025" readonly>
            </div>
            <button class="btn btn-gold" onclick="alert('Date range filter coming soon!')">Apply</button>
        </div>
    </div>

    <!-- KPI Cards (Glassmorphism style) -->
    <div class="row g-4 mb-5">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-lg h-100" style="background: linear-gradient(145deg, #ffffff, #f8f9fa); border-radius: 20px;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">+12.5%</span>
                        <i class="fas fa-arrow-up text-success"></i>
                    </div>
                    <h3 class="fw-bold mb-1">₹{{ number_format($revenueThisMonth, 2) }}</h3>
                    <p class="text-muted mb-0">Total Revenue <span class="text-dark">(this month)</span></p>
                    <div class="progress mt-3" style="height: 6px;">
                        <div class="progress-bar bg-gold" style="width: 75%"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-lg h-100" style="border-radius: 20px;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="badge bg-info bg-opacity-10 text-info px-3 py-2 rounded-pill">+4.2%</span>
                        <i class="fas fa-user-plus text-info"></i>
                    </div>
                    <h3 class="fw-bold mb-1">{{ $totalCustomers }}</h3>
                    <p class="text-muted mb-0">Total Customers</p>
                    <small class="text-success">↑ 2 this week</small>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-lg h-100" style="border-radius: 20px;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2 rounded-pill">▲ 8</span>
                        <i class="fas fa-clock text-warning"></i>
                    </div>
                    <h3 class="fw-bold mb-1">{{ $pendingOrders }}</h3>
                    <p class="text-muted mb-0">Pending Orders</p>
                    <small class="text-warning">requires attention</small>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-lg h-100" style="border-radius: 20px;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2 rounded-pill">▼ 3%</span>
                        <i class="fas fa-shopping-bag text-secondary"></i>
                    </div>
                    <h3 class="fw-bold mb-1">{{ $ordersThisMonth }}</h3>
                    <p class="text-muted mb-0">Total Orders <span class="text-dark">(this month)</span></p>
                    <small class="text-muted">vs 14 last month</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Sales Chart & Top Products -->
    <div class="row g-4 mb-5">
        <!-- Chart Card -->
        <div class="col-xl-8">
            <div class="card border-0 shadow-lg" style="border-radius: 20px;">
                <div class="card-header bg-transparent border-0 pt-4 px-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0">Sales Overview</h5>
                        <div>
                            <span class="badge bg-gold-light text-dark me-2">6 months</span>
                            <i class="fas fa-chevron-down text-muted"></i>
                        </div>
                    </div>
                </div>
                <div class="card-body px-4 pb-4">
                    <canvas id="salesChart" style="height: 300px; width: 100%;"></canvas>
                </div>
            </div>
        </div>

        <!-- Top Products Card -->
        <div class="col-xl-4">
            <div class="card border-0 shadow-lg" style="border-radius: 20px;">
                <div class="card-header bg-transparent border-0 pt-4 px-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0">Top Products</h5>
                        <span class="badge bg-gold-light text-dark">BEST SELLING</span>
                    </div>
                </div>
                <div class="card-body px-4">
                    @forelse($topProducts as $index => $product)
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle bg-gold-light text-dark d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px; font-weight: 600;">{{ $index + 1 }}</div>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-semibold">{{ $product->name }}</span>
                                <span class="fw-bold">₹{{ number_format($product->price ?? 0, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">{{ $product->category_name ?? 'Premium Cake' }}</small>
                                <small class="text-muted">{{ $product->total_qty ?? 0 }} sold</small>
                            </div>
                            <div class="progress mt-1" style="height: 4px;">
                                <div class="progress-bar bg-gold" style="width: {{ min(100, ($product->total_qty ?? 0) * 5) }}%"></div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <p class="text-muted text-center py-3">No sales data yet.</p>
                    @endforelse
                    <hr class="my-3">
                    <p class="small text-muted mb-0">*Detailed analytics coming soon</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Export & Additional Insights -->
    <div class="row g-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-lg" style="border-radius: 20px; background: linear-gradient(145deg, #f9f9f9, #ffffff);">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-download fa-2x text-gold me-3"></i>
                        <div>
                            <h5 class="fw-bold mb-0">Export Reports</h5>
                            <p class="text-muted small mb-0">Download your data in multiple formats</p>
                        </div>
                    </div>
                    <div class="row g-2">
                        <div class="col-6">
                            <a href="#" class="btn btn-outline-secondary w-100 py-3" onclick="alert('PDF export coming soon!')">
                                <i class="fas fa-file-pdf me-2 text-danger"></i> PDF Summary
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="#" class="btn btn-outline-secondary w-100 py-3" onclick="alert('Excel export coming soon!')">
                                <i class="fas fa-file-excel me-2 text-success"></i> Excel Data
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-lg" style="border-radius: 20px;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-chart-line fa-2x text-gold me-3"></i>
                        <div>
                            <h5 class="fw-bold mb-0">Quick Insights</h5>
                            <p class="text-muted small mb-0">AI‑powered predictions</p>
                        </div>
                    </div>
                    <p class="mb-2">📈 Revenue projected to grow 15% next month</p>
                    <p class="mb-2">🛒 Best day for orders: Saturdays</p>
                    <p class="mb-0">🎂 Most popular category: Chocolate Cakes</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .bg-gold-light {
        background-color: rgba(212, 175, 55, 0.1);
    }
    .text-gold {
        color: var(--gold);
    }
    .btn-gold {
        background: var(--gold);
        color: var(--dark);
        border: none;
        padding: 8px 20px;
        font-weight: 600;
        transition: 0.3s;
    }
    .btn-gold:hover {
        background: #b8952d;
        color: var(--dark);
    }
    .progress-bar.bg-gold {
        background-color: var(--gold) !important;
    }
    .card {
        transition: transform 0.3s ease;
    }
    .card:hover {
        transform: translateY(-5px);
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('salesChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($months) !!},
            datasets: [{
                label: 'Revenue (₹)',
                data: {!! json_encode($values) !!},
                backgroundColor: 'rgba(212, 175, 55, 0.7)',
                borderRadius: 8,
                barPercentage: 0.6,
                categoryPercentage: 0.7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return '₹' + context.raw.toLocaleString();
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: '#f0f0f0' },
                    ticks: {
                        callback: function(value) { return '₹' + value.toLocaleString(); }
                    }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });
});
</script>
@endpush