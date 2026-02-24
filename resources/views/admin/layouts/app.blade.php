<!DOCTYPE html>
<html>
<head>
    <title>Cake Shop</title>
</head>
<body>

    <nav>
        <a href="{{ route('home') }}">Home</a>

        @auth
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit">Logout</button>
            </form>
        @else
            <a href="{{ route('login') }}">Login</a>
        @endauth
    </nav>

    <div style="padding:20px;">
        @yield('content')
    </div>

</body>
</html>