<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blonde Bakery | Haute Couture Cakes</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">

    <!-- Bootstrap (optional, used for layout) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <!-- AOS CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.4.0/css/all.css">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('Fevicon_Cake.png') }}">

    <style>
        :root {
            --gold: #D4AF37;
            --cream: #F9F7F2;
            --dark: #1A1A1A;
            --white: #ffffff;
        }

        body {
            background-color: var(--cream);
            font-family: 'Montserrat', sans-serif;
            color: var(--dark);
            overflow-x: hidden;
        }
        .serif { font-family: 'Cormorant Garamond', serif; }
        .text-gold { color: var(--gold); }

        /* Navbar (unchanged but with scroll effect) */
        .navbar {
            padding: 1.5rem 0;
            transition: 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 2000 !important;
        }
        .navbar.scrolled {
            background: var(--cream);
            box-shadow: 0 10px 30px rgba(0,0,0,0.03);
        }
        .navbar-brand {
            font-size: 1.6rem;
            letter-spacing: 5px;
            font-weight: 600;
        }
        .nav-link {
            font-weight: 500;
            transition: 0.3s;
        }

        /* Floating cart (unchanged) */
        .floating-cart {
            position: fixed;
            top: 30px;
            right: 30px;
            z-index: 2100;
            width: 55px;
            height: 55px;
            background: var(--white);
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            color: var(--dark);
            text-decoration: none;
        }
        .cart-badge {
            position: absolute;
            top: 0;
            right: 0;
            background: var(--gold);
            color: white;
            border-radius: 50%;
            padding: 2px 7px;
            font-size: 0.65rem;
        }

        /* Hero slider (new) */
        .hero-slider {
            height: 100vh;
            overflow: hidden;
        }
        .swiper-slide {
            position: relative;
            background-size: cover;
            background-position: center;
        }
        .slide-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0,0,0,0.3);
        }
        .slide-content {
            position: relative;
            z-index: 2;
            color: white;
            text-align: center;
            padding: 0 20px;
        }
        .slide-title {
            font-size: 4.5rem;
            line-height: 1.1;
            text-shadow: 2px 2px 8px rgba(0,0,0,0.2);
        }
        .slide-subtitle {
            font-size: 1.2rem;
            margin: 20px 0 30px;
        }

        /* Buttons (your existing btn-luxury extended) */
        .btn-luxury {
            background: var(--dark);
            color: var(--white);
            border: 1px solid var(--dark);
            padding: 14px 35px;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 2px;
            transition: 0.4s;
            text-decoration: none;
            display: inline-block;
            cursor: pointer;
        }
        .btn-luxury:hover {
            background: transparent;
            color: var(--dark);
        }
        .btn-outline-light {
            border: 2px solid white;
            background: transparent;
            color: white;
        }
        .btn-outline-light:hover {
            background: white;
            color: var(--dark);
        }

        /* Product cards (enhanced) */
        .product-card {
            background: var(--white);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 45px rgba(0,0,0,0.05);
            transition: all 0.3s;
            margin-bottom: 80px;
        }
        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 50px rgba(212,175,55,0.1);
        }
        .product-img-wrap {
            height: 500px;
            overflow: hidden;
        }
        .product-img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: 1.2s;
        }
        .product-card:hover img {
            transform: scale(1.08);
        }
        .product-info-overlay {
            background: var(--white);
            padding: 30px;
            width: 85%;
            margin: -60px auto 0;
            position: relative;
            z-index: 5;
            text-align: center;
            box-shadow: 0 15px 45px rgba(0,0,0,0.05);
        }
        .product-category {
            color: var(--gold);
            text-transform: uppercase;
            font-size: 0.7rem;
            letter-spacing: 2px;
        }
        .product-name {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.5rem;
            margin: 8px 0;
        }
        .product-price {
            font-weight: 600;
            margin-bottom: 15px;
        }

        /* Footer (unchanged) */
        .luxury-footer {
            background-color: var(--dark);
            color: var(--white);
            padding: 80px 0 40px;
            margin-top: 100px;
        }
        /* ... keep all your existing footer styles ... */

        .dropdown-menu { border-radius: 0; padding: 15px 0; min-width: 220px; }
        .dropdown-item { padding: 8px 25px; transition: 0.2s; }
        .dropdown-item:hover { background-color: var(--cream); color: var(--gold); }
    </style>
</head>
<body>

    <!-- Success Alert (unchanged) -->
    @if(session('success'))
        <div class="alert alert-dismissible fade show custom-alert" role="alert">
            <span class="serif italic">✨ {{ session('success') }}</span>
            <hr style="border-color: rgba(212, 175, 55, 0.3);">
            <a href="{{ route('cart.index') }}" class="text-gold small text-uppercase text-decoration-none letter-spacing-2">View Your Bag</a>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <a href="{{ route('cart.index') }}" class="floating-cart">
        <i class="fa-solid fa-cart-shopping"></i>
        @php $cartCount = session('cart') ? count(session('cart')) : 0; @endphp
        <span class="cart-badge">{{ $cartCount }}</span>
    </a>

    <!-- Navbar (unchanged, just added scroll detection) -->
    <nav class="navbar navbar-expand-lg fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand serif text-dark text-decoration-none" href="{{ route('home') }}">BLONDE BAKERY.</a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav align-items-center gap-2">
                <li class="nav-item me-3">
    <a class="nav-link text-uppercase small letter-spacing-2" href="{{ route('categories.index') }}">Categories</a>
</li>    
                <li class="nav-item me-3">
                        <a class="nav-link text-uppercase small letter-spacing-2" href="#collection">Collection</a>
                    </li>

                    <div class="d-flex align-items-center gap-2 ms-lg-3 border-start ps-lg-4" style="border-color: rgba(0,0,0,0.1) !important;">
                        @auth
                            <li class="nav-item me-2">
                                <span class="serif italic text-dark me-2" style="font-size: 0.95rem;">
                                    Hi, {{ Auth::user()->name }}
                                </span>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle small text-gold" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-regular fa-user"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg" aria-labelledby="userDropdown">
                                    @if(Auth::user()->is_admin || Auth::user()->email == 'geeta@xyz.com')
                                        <li><a class="dropdown-item small text-uppercase letter-spacing-1" href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-gauge-high me-2"></i> Dashboard</a></li>
                                        <li><a class="dropdown-item small text-uppercase letter-spacing-1" href="{{ route('admin.products.index') }}"><i class="fa-solid fa-cake-candles me-2"></i> Products</a></li>
                                        <li><a class="dropdown-item small text-uppercase letter-spacing-1" href="{{ route('admin.orders.index') }}"><i class="fa-solid fa-receipt me-2"></i> Orders</a></li>
                                    @else
                                        <li><a class="dropdown-item small text-uppercase letter-spacing-1" href="{{ route('cart.index') }}"><i class="fa-solid fa-bag-shopping me-2"></i> My Bag</a></li>
                                        <li><a class="dropdown-item small text-uppercase letter-spacing-1" href="{{ route('customer.orders') }}"><i class="fa-solid fa-box me-2"></i> My Orders</a></li>
                                    @endif
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST" class="m-0">
                                            @csrf
                                            <button type="submit" class="dropdown-item small text-uppercase text-danger opacity-75"><i class="fa-solid fa-arrow-right-from-bracket me-2"></i> Logout</button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @else
                            <li class="nav-item">
                                <a href="{{ route('login') }}" class="nav-link text-uppercase small" style="font-size: 0.65rem;">Sign In</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('register') }}" class="btn-register-luxury text-decoration-none">Register</a>
                            </li>
                        @endauth
                    </div>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Slider (replaces your old hero-split) -->
    <section class="hero-slider">
        <div class="swiper heroSwiper h-100">
            <div class="swiper-wrapper">
                <!-- Slide 1 -->
                <div class="swiper-slide" style="background-image: url('https://images.unsplash.com/photo-1621303837174-89787a7d4729?q=80&w=1936');">
                    <div class="slide-overlay"></div>
                    <div class="d-flex align-items-center justify-content-center h-100">
                        <div class="slide-content" data-aos="fade-up">
                            <span class="text-gold text-uppercase small letter-spacing-3">Haute Couture</span>
                            <h1 class="slide-title serif">Artistry on a Plate</h1>
                            <p class="slide-subtitle">Handcrafted masterpieces for life's sweetest moments</p>
                            <a href="#collection" class="btn-luxury btn-outline-light me-2">Explore</a>
                            <a href="#collection" class="btn-luxury">Shop Now</a>
                        </div>
                    </div>
                </div>
                <!-- Slide 2 -->
                <div class="swiper-slide" style="background-image: url('https://images.unsplash.com/photo-1578985545062-69928b1d9587?q=80&w=1000');">
                    <div class="slide-overlay"></div>
                    <div class="d-flex align-items-center justify-content-center h-100">
                        <div class="slide-content" data-aos="fade-up">
                            <span class="text-gold text-uppercase small letter-spacing-3">Wedding Edition</span>
                            <h1 class="slide-title serif">Your Dream in Sugar</h1>
                            <p class="slide-subtitle">Bespoke designs for the most important day</p>
                            <a href="#collection" class="btn-luxury btn-outline-light me-2">Discover</a>
                            <a href="#collection" class="btn-luxury">View Collection</a>
                        </div>
                    </div>
                </div>
                <!-- Slide 3 -->
                <div class="swiper-slide" style="background-image: url('https://images.unsplash.com/photo-1565958011703-44f9829ba187?q=80&w=1000');">
                    <div class="slide-overlay"></div>
                    <div class="d-flex align-items-center justify-content-center h-100">
                        <div class="slide-content" data-aos="fade-up">
                            <span class="text-gold text-uppercase small letter-spacing-3">Celebration</span>
                            <h1 class="slide-title serif">Sweet Memories</h1>
                            <p class="slide-subtitle">Custom creations for every occasion</p>
                            <a href="#collection" class="btn-luxury btn-outline-light me-2">Explore</a>
                            <a href="#collection" class="btn-luxury">Shop Now</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
    </section>

    <!-- Products Section (only first 6 products shown, with AOS animations) -->
    <section id="collection" class="py-5">
        <div class="container py-5">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="serif h1 italic">The Signature Series</h2>
                <div style="width: 50px; height: 2px; background: var(--gold); margin: 20px auto;"></div>
            </div>

            <div class="row">
                @forelse($products->take(6) as $index => $product)
                <div class="col-lg-6 {{ $index % 2 != 0 ? 'mt-lg-5' : '' }}" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                    <div class="product-card px-3">
                        <div class="product-img-wrap">
                            <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid" alt="{{ $product->name }}" onerror="this.src='https://via.placeholder.com/500x500?text=Cake';">
                        </div>
                        <div class="product-info-overlay">
                            <span class="product-category">{{ $product->category->name ?? 'Couture' }}</span>
                            <h3 class="product-name">{{ $product->name }}</h3>
                            <p class="product-price">₹{{ number_format($product->price, 2) }}</p>
                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-luxury">Reserve this piece</button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <p class="serif h4 text-muted">New designs are being curated in our kitchen...</p>
                </div>
                @endforelse
            </div>
            <div class="text-center mt-5">
                <a href="#" class="btn-luxury">View All Collection</a>
            </div>
        </div>
    </section>

    <!-- Footer (unchanged) -->
    <footer class="luxury-footer">
        <div class="container">
            <!-- ... your full footer content here (keep exactly as before) ... -->
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Initialize AOS
        AOS.init({ duration: 800, once: true });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const nav = document.querySelector('.navbar');
            if (window.scrollY > 80) {
                nav.classList.add('scrolled');
            } else {
                nav.classList.remove('scrolled');
            }
        });

        // Swiper
        const heroSwiper = new Swiper('.heroSwiper', {
            loop: true,
            autoplay: { delay: 4000, disableOnInteraction: false },
            speed: 1000,
            pagination: { el: '.swiper-pagination', clickable: true },
            navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
        });

        // Auto-close alert (unchanged)
        setTimeout(function() {
            let alert = document.querySelector('.custom-alert');
            if(alert) {
                let bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        }, 5000);
    </script>
</body>
</html>