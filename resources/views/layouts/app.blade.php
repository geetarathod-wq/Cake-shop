<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Blonde Bakery')</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">

    <!-- Bootstrap (optional) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom styles -->
    <style>
        :root {
            --gold: #D4AF37;
            --cream: #F9F7F2;
            --dark: #1A1A1A;
        }
        body {
            background-color: var(--cream);
            font-family: 'Montserrat', sans-serif;
            color: var(--dark);
        }
        .serif {
            font-family: 'Cormorant Garamond', serif;
        }
        .text-gold {
            color: var(--gold);
        }
        .btn-luxury {
            background: var(--dark);
            color: white;
            border: 1px solid var(--dark);
            padding: 10px 30px;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 2px;
            transition: 0.3s;
            text-decoration: none;
            display: inline-block;
            border-radius: 50px;
        }
        .btn-luxury:hover {
            background: transparent;
            color: var(--dark);
        }
        /* Navbar */
        .navbar {
            padding: 1.5rem 0;
        }
        .navbar-brand {
            font-size: 1.6rem;
            letter-spacing: 5px;
            font-weight: 600;
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Simple Navbar (updated with Home on the right) -->
    <nav class="navbar">
        <div class="container">
            <a class="navbar-brand serif text-dark text-decoration-none" href="{{ route('home') }}">BLONDE BAKERY</a>
            <div>
                <!-- Home link added here -->
                <a href="{{ route('home') }}" class="text-dark me-3">Home</a>
                @auth
                    <span class="me-3">Hi, {{ Auth::user()->name }}</span>
                    <a href="{{ route('customer.orders') }}" class="text-dark me-3">My Orders</a>
                    <a href="{{ route('cart.index') }}" class="text-dark me-3">Cart</a>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-link text-dark">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-dark me-3">Login</a>
                    <a href="{{ route('register') }}" class="text-dark">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Simple Footer (optional) -->
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container text-center">
            <p class="mb-0">&copy; {{ date('Y') }} Blonde Bakery. All rights reserved.</p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>