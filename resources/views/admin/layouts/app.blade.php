<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') | Blonde Bakery</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap & Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        :root {
            --gold: #D4AF37;
            --gold-light: rgba(212, 175, 55, 0.1);
            --cream: #F9F7F2;
            --dark: #1A1A1A;
            --sidebar-width: 260px;
        }

        body {
            background: #f8f9fc;
            font-family: 'Montserrat', sans-serif;
            color: var(--dark);
        }

        .serif { font-family: 'Cormorant Garamond', serif; }

        /* ---------- SIDEBAR ---------- */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(145deg, #1e1e1e 0%, #2a2a2a 100%);
            position: fixed;
            left: 0;
            top: 0;
            padding: 2rem 1rem;
            color: white;
            z-index: 1000;
            overflow-y: auto;
            box-shadow: 5px 0 25px rgba(0,0,0,0.15);
        }

        .sidebar-brand {
            font-size: 1.4rem;
            font-weight: 700;
            letter-spacing: 4px;
            color: var(--gold);
            text-decoration: none;
            display: block;
            margin-bottom: 2rem;
            border-bottom: 2px solid rgba(212, 175, 55, 0.3);
            padding-bottom: 1rem;
            text-transform: uppercase;
            transition: all 0.3s;
        }
        .sidebar-brand:hover {
            letter-spacing: 6px;
            color: #e5c158;
        }

        .nav-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .nav-item {
            margin-bottom: 0.5rem;
        }

        .nav-link {
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 12px 18px;
            border-radius: 9999px;        /* rounded-full */
            transition: all 0.3s ease;
            font-size: 0.9rem;
            font-weight: 600;              /* font-bold */
            text-transform: uppercase;      /* uppercase */
            letter-spacing: 0.5px;
        }

        .nav-link i {
            width: 28px;
            font-size: 1.2rem;
            margin-right: 12px;
            text-align: center;
        }

        .nav-link:hover,
        .nav-link.active,
        .nav-link.show {
            background: var(--gold);
            color: var(--dark);
            transform: translateX(5px);
            box-shadow: 0 10px 20px rgba(212, 175, 55, 0.3);
        }

        /* ---------- MAIN CONTENT ---------- */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 2rem 2.5rem;
            background: #f8f9fc;
            min-height: 100vh;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2.5rem;
            background: white;
            padding: 1rem 2rem;
            border-radius: 9999px;         /* rounded-full */
            box-shadow: 0 5px 20px rgba(0,0,0,0.03);
        }

        /* ---------- UTILITY CLASSES ---------- */
        .rounded-full {
            border-radius: 9999px !important;
        }

        .font-bold {
            font-weight: 600 !important;
        }

        .uppercase {
            text-transform: uppercase !important;
        }

        .tracking-wide {
            letter-spacing: 0.025em !important;
        }

        .bg-gold-light {
            background: var(--gold-light) !important;
            color: var(--gold) !important;
        }

        /* ---------- CARD & TABLE STYLES (optional, for dashboard use) ---------- */
        .stat-card {
            background: white;
            border: none;
            border-radius: 24px;
            padding: 1.5rem;
            box-shadow: 0 15px 30px rgba(0,0,0,0.05);
            transition: 0.3s;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 35px rgba(212, 175, 55, 0.1);
        }

        .icon-box {
            width: 54px;
            height: 54px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
        }

        .table-container {
            background: white;
            border-radius: 30px;
            padding: 1.5rem;
            box-shadow: 0 15px 30px rgba(0,0,0,0.03);
        }

        .badge-status {
            padding: 6px 16px;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .btn-gold {
            background: var(--gold);
            color: var(--dark);
            border: none;
            padding: 10px 24px;
            font-weight: 600;
            border-radius: 9999px;
            transition: 0.3s;
        }
        .btn-gold:hover {
            background: #c4a035;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(212, 175, 55, 0.3);
        }

        /* Custom scrollbar for sidebar */
        .sidebar::-webkit-scrollbar {
            width: 4px;
        }
        .sidebar::-webkit-scrollbar-thumb {
            background: var(--gold);
            border-radius: 10px;
        }
    </style>

    @stack('styles')
</head>
<body>
    <!-- SIDEBAR -->
    <div class="sidebar">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-brand serif">
            BLONDE BAKERY
        </a>
        <ul class="nav-menu">
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-pie"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.orders.index') }}" class="nav-link">
                    <i class="fas fa-shopping-bag"></i>
                    <span>Orders</span>
                </a>
            </li>


            <li class="nav-item">
                <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products*') ? 'active' : '' }}">
                    <i class="fas fa-cake-candles"></i> Products
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories*') ? 'active' : '' }}">
                    <i class="fas fa-tags"></i> Categories
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.reports.index') }}" class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i> Reports
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.settings.index') }}" class="nav-link {{ request()->routeIs('admin.settings*') ? 'active' : '' }}">
                    <i class="fas fa-cog"></i> Settings
                </a>
            </li>

            <li class="nav-item mt-5">
                <a href="{{ route('home') }}" class="nav-link" target="_blank">
                    <i class="fas fa-eye"></i> View Site
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content">
        @yield('content')
    </div>

    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>