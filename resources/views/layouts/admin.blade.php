<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | MyCakes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('Fevicon_Cake.png') }}">
    <style>
        :root {
            --primary-pink: #e91e63;
            --dark-sidebar: #1e1e2d;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7f6;
            margin: 0;
        }

        /* Sidebar Styling */
        .sidebar {
            width: 260px;
            height: 100vh;
            background: var(--dark-sidebar);
            position: fixed;
            transition: all 0.3s;
            z-index: 1000;
        }

        .sidebar-header {
            padding: 20px;
            text-align: center;
            background: rgba(0,0,0,0.1);
        }

        .sidebar-header h3 {
            color: #fff;
            font-weight: 600;
            margin: 0;
            letter-spacing: 1px;
        }

        .nav-links {
            padding-top: 20px;
            list-style: none;
            padding-left: 0;
        }

        .nav-links li a {
            display: flex;
            align-items: center;
            padding: 15px 25px;
            color: #a2a3b7;
            text-decoration: none;
            transition: 0.3s;
        }

        .nav-links li a i {
            margin-right: 15px;
            width: 20px;
            font-size: 1.1rem;
        }

        .nav-links li a:hover, .nav-links li a.active {
            color: #fff;
            background: var(--primary-pink);
        }

        /* Main Content Area */
        .main-content {
            margin-left: 260px;
            padding: 30px;
            min-height: 100vh;
        }

        .top-navbar {
            background: #fff;
            padding: 15px 30px;
            margin-bottom: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar { margin-left: -260px; }
            .main-content { margin-left: 0; }
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="sidebar-header">
            <h3>MyCakes</h3>
        </div>
        <ul class="nav-links">
            <li>
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
                    <i class="fas fa-th-large"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('admin.products') }}" class="{{ request()->is('admin/products*') ? 'active' : '' }}">
                    <i class="fas fa-birthday-cake"></i> Products
                </a>
            </li>
            <li>
                <a href="{{ route('admin.categories') }}" class="{{ request()->is('admin/categories*') ? 'active' : '' }}">
                    <i class="fas fa-tags"></i> Categories
                </a>
            </li>
            <li>
                <a href="{{ route('admin.orders') }}" class="{{ request()->is('admin/orders*') ? 'active' : '' }}">
                    <i class="fas fa-shopping-cart"></i> Orders
                </a>
            </li>
            <li>
                <a href="{{ route('admin.settings') }}" class="{{ request()->is('admin/settings*') ? 'active' : '' }}">
                    <i class="fas fa-user-cog"></i> Settings
                </a>
            </li>
            <li class="mt-5">
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" style="background:none; border:none; color:#a2a3b7; padding: 15px 25px; width:100%; text-align:left;">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </li>
        </ul>
    </div>

    <div class="main-content">
        <div class="top-navbar">
            <h5 class="m-0">Welcome back, Admin</h5>
            <div>
                <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm" target="_blank">
                    <i class="fas fa-eye"></i> View Shop
                </a>
            </div>
        </div>

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>