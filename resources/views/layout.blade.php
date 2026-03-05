<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyCakes - Bakery Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('Fevicon_Cake.png') }}">
    <style>
        body { background-color: #fdf8f5; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .navbar { background-color: #fff; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .navbar-brand { font-weight: bold; color: #d63384 !important; }
        .nav-link:hover { color: #d63384 !important; }
        .footer { padding: 40px 0; background: #fff; margin-top: 50px; border-top: 1px solid #eee; }
        .admin-sidebar .list-group-item.active { background-color: #d63384; border-color: #d63384; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fa-solid fa-cake-candles me-2"></i>MyCakes
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>

                    @auth
                        @if(Auth::user()->is_admin)
                            <li class="nav-item"><a class="nav-link fw-bold text-primary" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        @else
                            <li class="nav-item"><a class="nav-link" href="{{ route('cart.index') }}">My Cart</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('customer.orders') }}">My Orders</a></li>
                        @endif

                        <li class="nav-item ms-lg-3">
                            <form action="{{ route('logout') }}" method="POST" class="m-0">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-danger">Logout</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                        <li class="nav-item"><a class="btn btn-sm btn-pink text-white ms-lg-2" style="background-color: #d63384;" href="{{ route('register') }}">Register</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row">
            @auth
                @if(Auth::user()->is_admin && !Route::is('home'))
                    <div class="col-md-3 mb-4">
                        <div class="card border-0 shadow-sm admin-sidebar">
                            <div class="card-header bg-white fw-bold">Admin Menu</div>
                            <div class="list-group list-group-flush">
                                <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action {{ Route::is('admin.dashboard') ? 'active' : '' }}">
                                    <i class="fa-solid fa-gauge me-2"></i> Dashboard
                                </a>
                                <a href="{{ route('admin.categories') }}" class="list-group-item list-group-item-action {{ Route::is('admin.categories') ? 'active' : '' }}">
                                    <i class="fa-solid fa-list me-2"></i> Categories
                                </a>
                                <a href="{{ route('admin.products') }}" class="list-group-item list-group-item-action {{ Route::is('admin.products') ? 'active' : '' }}">
                                    <i class="fa-solid fa-cake-candles me-2"></i> Products
                                </a>
                                <a href="{{ route('admin.orders') }}" class="list-group-item list-group-item-action {{ Route::is('admin.orders') ? 'active' : '' }}">
                                    <i class="fa-solid fa-cart-shopping me-2"></i> Customer Orders
                                </a>
                                <a href="{{ route('admin.settings') }}" class="list-group-item list-group-item-action {{ Route::is('admin.settings') ? 'active' : '' }}">
                                    <i class="fa-solid fa-gear me-2"></i> Settings
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        @yield('content')
                    </div>
                @else
                    <div class="col-12">
                        @yield('content')
                    </div>
                @endif
            @else
                <div class="col-12">
                    @yield('content')
                </div>
            @endauth
        </div>
    </div>

    <footer class="footer text-center mt-auto">
        <div class="container">
            <p class="text-muted mb-0">&copy; 2026 MyCakes Bakery Shop. All Rights Reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>