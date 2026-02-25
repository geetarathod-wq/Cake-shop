<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
</head>
<body>
@if(auth()->check() && auth()->user()->is_admin == 1)
    <div style="width:200px; float:left; background:#f2f2f2; height:100vh;">
        <h3>Admin Sidebar</h3>
        <ul>
            <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li><a href="#">Products</a></li>
            <li><a href="#">Orders</a></li>
        </ul>
    </div>

    <div style="margin-left:210px; padding:20px;">
        @yield('content')
    </div>
@endif
</body>
</html>