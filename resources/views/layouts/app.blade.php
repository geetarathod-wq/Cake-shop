<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - MyCakes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        .sidebar { min-width: 250px; min-height: 100vh; background: #212529; color: white; }
        .nav-link { color: #ccc; }
        .nav-link:hover { color: white; background: #343a40; }
    </style>
</head>
<body>
    <div class="d-flex">
        <div class="sidebar p-3">
            <h3>MyCakes Admin</h3>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li><a href="{{ route('admin.dashboard') }}" class="nav-link"><i class="fas fa-chart-line me-2"></i> Dashboard</a></li>
                <li><a href="{{ route('admin.products.index') }}" class="nav-link"><i class="fas fa-cake me-2"></i> Products</a></li>
                <li><a href="{{ route('admin.categories.index') }}" class="nav-link"><i class="fas fa-list me-2"></i> Categories</a></li>
                <li><a href="{{ route('admin.orders.index') }}" class="nav-link"><i class="fas fa-shopping-bag me-2"></i> Orders</a></li>
                <li><a href="{{ route('admin.settings.index') }}" class="nav-link"><i class="fas fa-cog me-2"></i> Settings</a></li>
            </ul>
        </div>
        <div class="flex-grow-1 bg-light">
            <nav class="navbar navbar-expand-lg navbar-white bg-white border-bottom p-3">
                <span class="navbar-text">Logged in as: <strong>{{ Auth::user()->name ?? 'Admin' }}</strong></span>
            </nav>
            <div class="p-4">
                @yield('content') </div>
        </div>
    </div>
</body>
</html>