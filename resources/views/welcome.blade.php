<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blonde Bakery | Haute Couture Cakes</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
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

        .serif {
            font-family: 'Cormorant Garamond', serif;
        }

        .text-gold {
            color: var(--gold);
        }

        /* Navbar */
        .navbar {
            padding: 1.5rem 0;
            transition: 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .navbar.scrolled {
            background: var(--cream);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
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

        /* Floating cart */
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
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
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

        /* Hero Split */
        .hero-split {
            position: relative;
            height: 100vh;
            display: flex;
            align-items: center;
            background: var(--cream);
            overflow: hidden;
        }

        .hero-split .hero-slider {
            position: absolute;
            top: 0;
            right: 0;
            width: 55%;
            height: 100%;
            clip-path: polygon(15% 0%, 100% 0, 100% 100%, 0% 100%);
            z-index: 1;
        }

        .hero-split .swiper,
        .hero-split .swiper-wrapper,
        .hero-split .swiper-slide {
            height: 100%;
        }

        .hero-split .swiper-slide {
            background-size: cover;
            background-position: center;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        /* Buttons */
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

        /* Product cards */
        .product-card {
            background: var(--white);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 45px rgba(0, 0, 0, 0.05);
            transition: all 0.3s;
            margin-bottom: 80px;
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 50px rgba(212, 175, 55, 0.1);
        }

        .product-img-wrap {
            height: 250px;
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
            box-shadow: 0 15px 45px rgba(0, 0, 0, 0.05);
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

        /* Story Section */
        .story-section {
            padding: 100px 0;
            background: var(--white);
        }

        .story-image {
            border-radius: 30px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }

        .story-image img {
            width: 100%;
            height: auto;
            transition: transform 0.5s;
        }

        .story-image:hover img {
            transform: scale(1.02);
        }

        .story-content {
            padding: 40px;
        }

        .story-content h2 {
            font-size: 3.5rem;
            margin-bottom: 20px;
        }

        .story-content p {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #666;
        }

        /* Testimonials */
        .testimonial-section {
            padding: 80px 0;
            background: var(--cream);
        }

        .testimonial-card {
            background: white;
            border-radius: 30px;
            padding: 30px;
            box-shadow: 0 15px 30px rgba(0,0,0,0.03);
            margin: 20px;
        }

        .testimonial-avatar {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 15px;
        }

        .testimonial-name {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .testimonial-role {
            color: var(--gold);
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .testimonial-text {
            font-style: italic;
            color: #555;
            margin: 15px 0;
        }

        .stars {
            color: var(--gold);
        }

        /* Footer */
        .luxury-footer {
            background-color: var(--dark);
            color: var(--white);
            padding: 80px 0 40px;
            margin-top: 100px;
        }

        .footer-brand {
            font-size: 1.8rem;
            letter-spacing: 4px;
            color: var(--gold) !important;
        }

        .footer-header {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 3px;
            color: var(--gold);
            margin-bottom: 25px;
            display: block;
        }

        .footer-link {
            color: rgba(255,255,255,0.6);
            text-decoration: none;
            display: block;
            margin-bottom: 12px;
            font-size: 0.85rem;
            transition: 0.3s;
        }

        .footer-link:hover {
            color: var(--gold);
            transform: translateX(5px);
        }

        .social-icon {
            font-size: 1.1rem;
            color: var(--white);
            margin-right: 20px;
            transition: 0.3s;
            opacity: 0.7;
        }

        .social-icon:hover {
            opacity: 1;
            color: var(--gold);
        }

        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.05);
            margin-top: 60px;
            padding-top: 30px;
            font-size: 0.65rem;
            letter-spacing: 2px;
            color: rgba(255,255,255,0.4);
        }

        /* Food icon */
        .food-icon {
            width: 16px;
            height: 16px;
            border: 2px solid;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 6px;
            border-radius: 3px;
        }

        .food-icon::after {
            content: "";
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }

        .veg {
            border-color: #28a745;
        }

        .veg::after {
            background-color: #28a745;
        }

        .non-veg {
            border-color: #dc3545;
        }

        .non-veg::after {
            background-color: #dc3545;
        }

        /* Egg toggle */
        .egg-toggle {
            position: relative;
            display: inline-block;
            width: 70px;
            height: 34px;
        }

        .egg-toggle input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .egg-toggle .slider {
            position: absolute;
            cursor: pointer;
            inset: 0;
            background-color: #dc3545;
            border-radius: 50px;
            transition: .4s;
        }

        .egg-toggle .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            border-radius: 50%;
            transition: .4s;
        }

        .egg-toggle input:checked+.slider {
            background-color: #28a745;
        }

        .egg-toggle input:checked+.slider:before {
            transform: translateX(36px);
        }

        #eggText {
            transition: 0.4s ease;
        }

        .egg-active {
            color: #28a745;
            transform: scale(1.05);
        }
    </style>
</head>

<body>

    <!-- Success Alert -->
    @if(session('success'))
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 3000;">
        <div class="toast show align-items-center text-white bg-dark border-0 shadow" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    ✨ {{ session('success') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>
    @endif

    <!-- Floating Cart -->
    <a href="{{ route('cart.index') }}" class="floating-cart">
        <i class="fa-solid fa-cart-shopping"></i>
        @php
            if (Auth::check()) {
                $cart = Auth::user()->cart;
                $cartCount = $cart ? $cart->items->sum('quantity') : 0;
            } else {
                $cartCount = session('cart') ? count(session('cart')) : 0;
            }
        @endphp
        <span class="cart-badge">{{ $cartCount }}</span>
    </a>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand serif text-dark text-decoration-none" href="{{ route('home') }}">BLONDE BAKERY</a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav align-items-center gap-2">
                    <li class="nav-item me-3">
                        <a class="nav-link text-uppercase small letter-spacing-2" href="{{ route('categories.index') }}">Categories</a>
                    </li>
                    <li class="nav-item me-3">
                        <a class="nav-link text-uppercase small letter-spacing-2" href="#story">Our Story</a>
                    </li>
                    <li class="nav-item me-3">
                        <a class="nav-link text-uppercase small letter-spacing-2" href="#reviews">Reviews</a>
                    </li>

                    <div class="d-flex align-items-center gap-2 ms-lg-3 border-start ps-lg-4" style="border-color: rgba(0,0,0,0.1) !important;">
                        @auth
                        <li class="nav-item me-2">
                            <span class="serif italic text-dark me-2" style="font-size: 1rem;">
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
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
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

    <!-- Hero Section -->
    <section class="hero-split">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 hero-content" data-aos="fade-up">
                    <span class="text-gold text-uppercase small letter-spacing-3 d-block mb-3">
                        Pune | Paris | Tokyo
                    </span>
                    <h1 class="serif" style="font-size: 4.5rem; line-height:1.1;">
                        Elegance <br> You Can Taste.
                    </h1>
                    <p class="lead opacity-75 my-4">
                        Designing bespoke couture cakes that serve as the centerpiece
                        for your most cherished celebrations.
                    </p>
                    <a href="{{ route('categories.index') }}" class="btn-luxury">
                        View Collection
                    </a>
                </div>
            </div>
        </div>
        <div class="hero-slider">
            <div class="swiper heroSwiper h-100">
                <div class="swiper-wrapper">
                    @foreach($sliderProducts as $product)
                    <div class="swiper-slide" style="background-image: url('{{ asset('storage/' . $product->image) }}');"></div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <br>

    <!-- Egg Toggle (optional) -->
    <div class="d-flex justify-content-center align-items-center mb-4">
        <label class="egg-toggle">
            <input type="checkbox" id="eggToggle" {{ request('egg') == 'eggless' ? 'checked' : '' }}>
            <span class="slider"></span>
        </label>
        <span id="eggText" class="ms-3 fw-semibold">
            Eggless Mode OFF
        </span>
    </div>

    <!-- Signature Cakes Section (6 items) -->
    <section id="collection" class="py-5">
        <div class="container py-5">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="serif h1 italic">Signature Cakes</h2>
                <div style="width: 50px; height: 2px; background: var(--gold); margin: 20px auto;"></div>
                <p class="text-muted">A curated selection of our most beloved creations</p>
            </div>

            <!-- Product Grid (6 items) -->
            <div class="row">
                @forelse($products->take(6) as $index => $product)
                <div class="col-lg-6 {{ $index % 2 != 0 ? 'mt-lg-5' : '' }} product-item"
                    data-category="{{ $product->category_id }}"
                    data-egg="{{ $product->egg_type }}"
                    data-aos="fade-up"
                    data-aos-delay="{{ $index * 100 }}">
                    <div class="product-card">
                        <div class="product-img-wrap">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                 onerror="this.src='https://via.placeholder.com/500x500?text=Cake';">
                        </div>
                        <div class="product-info-overlay">
                            <span class="product-category">
                                @if($product->egg_type == 'eggless')
                                <span class="food-icon veg"></span>
                                @else
                                <span class="food-icon non-veg"></span>
                                @endif
                                {{ $product->category->name ?? 'Couture' }}
                            </span>
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
                <a href="{{ route('categories.index') }}" class="btn-luxury">View All Collection</a>
            </div>
        </div>
    </section>

    <!-- Our Story Section -->
    <section id="story" class="story-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-right">
                    <div class="story-image">
                        <img src="https://images.unsplash.com/photo-1464347744102-11db6282f854?q=80&w=1000" alt="Our Bakery" class="img-fluid">
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="story-content">
                        <span class="text-gold text-uppercase small letter-spacing-3">Our Story</span>
                        <h2 class="serif">Passion Baked <br>Since 2026</h2>
                        <p>Blonde Bakery was born from a dream to elevate the art of patisserie. Every cake is a labor of love, combining the finest ingredients with couture design. Our atelier in Pune crafts bespoke creations for connoisseurs around the world.</p>
                        <p>From intimate celebrations to grand weddings, we transform your vision into edible art. Each creation tells a story of love, tradition, and couture design.</p>
                        <a href="#" class="btn-luxury mt-3">Meet the Team</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Customer Reviews Section -->
    <section id="reviews" class="testimonial-section">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="serif h1">Client Love</h2>
                <div style="width: 50px; height: 2px; background: var(--gold); margin: 20px auto;"></div>
            </div>
            <div class="swiper testimonialSwiper">
                <div class="swiper-wrapper">
                    <!-- Review 1 -->
                    <div class="swiper-slide">
                        <div class="testimonial-card text-center">
                            <img src="https://randomuser.me/api/portraits/women/44.jpg" class="testimonial-avatar">
                            <div class="stars mb-2">
                                <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                            </div>
                            <p class="testimonial-text">"Absolutely exquisite! The cake was the centerpiece of our wedding and tasted as divine as it looked."</p>
                            <h5 class="testimonial-name">Anjali Sharma</h5>
                            <span class="testimonial-role">Bride</span>
                        </div>
                    </div>
                    <!-- Review 2 -->
                    <div class="swiper-slide">
                        <div class="testimonial-card text-center">
                            <img src="https://randomuser.me/api/portraits/men/32.jpg" class="testimonial-avatar">
                            <div class="stars mb-2">
                                <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                            </div>
                            <p class="testimonial-text">"The attention to detail is incredible. Every bite was pure bliss. Highly recommended!"</p>
                            <h5 class="testimonial-name">Raj Mehta</h5>
                            <span class="testimonial-role">Birthday Celebrant</span>
                        </div>
                    </div>
                    <!-- Review 3 -->
                    <div class="swiper-slide">
                        <div class="testimonial-card text-center">
                            <img src="https://randomuser.me/api/portraits/women/68.jpg" class="testimonial-avatar">
                            <div class="stars mb-2">
                                <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                            </div>
                            <p class="testimonial-text">"We've ordered multiple times for corporate events. Always a showstopper."</p>
                            <h5 class="testimonial-name">Priya Kapoor</h5>
                            <span class="testimonial-role">Event Manager</span>
                        </div>
                    </div>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="luxury-footer">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-4" data-aos="fade-up">
                    <a href="#" class="footer-brand serif text-decoration-none d-block mb-3">BLONDE BAKERY</a>
                    <p class="small opacity-50" style="line-height: 1.8; max-width: 300px;">
                        Crafting artisanal treats with the finest ingredients since 2026.
                        Every cake tells a story of love, tradition, and couture design.
                    </p>
                    <div class="mt-4">
                        <a href="#" class="social-icon"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" class="social-icon"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#" class="social-icon"><i class="fa-brands fa-pinterest-p"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-6" data-aos="fade-up" data-aos-delay="100">
                    <span class="footer-header serif italic">Boutique</span>
                    <a href="{{ route('home') }}" class="footer-link">Home</a>
                    <a href="{{ route('categories.index') }}" class="footer-link">Collection</a>
                    <a href="#" class="footer-link">Track Order</a>
                    <a href="#" class="footer-link">Gifting</a>
                </div>
                <div class="col-lg-3 col-6" data-aos="fade-up" data-aos-delay="200">
                    <span class="footer-header serif italic">Inquiries</span>
                    <p class="footer-link mb-1"><i class="fa-solid fa-location-dot me-2 text-gold"></i> Pune, India</p>
                    <p class="footer-link mb-1"><i class="fa-solid fa-phone me-2 text-gold"></i> +91 98765 43210</p>
                    <p class="footer-link"><i class="fa-solid fa-envelope me-2 text-gold"></i> hello@blondebakery.com</p>
                </div>
                <div class="col-lg-3" data-aos="fade-up" data-aos-delay="300">
                    <span class="footer-header serif italic">Connect</span>
                    <p class="small opacity-50 mb-4">Follow us for daily sweet inspirations and artistry.</p>
                    <div class="position-relative">
                        <input type="email" class="form-control bg-transparent border-0 border-bottom rounded-0 px-0 text-white shadow-none"
                               placeholder="Newsletter" style="border-color: rgba(255,255,255,0.1) !important; font-size: 0.8rem;">
                        <button class="btn p-0 position-absolute end-0 top-0 text-gold"><i class="fa-solid fa-arrow-right-long"></i></button>
                    </div>
                </div>
            </div>
            <div class="footer-bottom text-center text-uppercase">
                <p class="mb-0">© 2026 BLONDE BAKERY ARTISANAL CAKES. ALL RIGHTS RESERVED.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 800, once: true });

        window.addEventListener('scroll', function() {
            const nav = document.querySelector('.navbar');
            if (window.scrollY > 80) {
                nav.classList.add('scrolled');
            } else {
                nav.classList.remove('scrolled');
            }
        });

        // Hero Swiper
        const heroSwiper = new Swiper('.heroSwiper', {
            loop: true,
            autoplay: { delay: 4000, disableOnInteraction: false },
            speed: 1000,
            pagination: { el: '.swiper-pagination', clickable: true },
            navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
        });

        // Testimonials Swiper
        const testimonialSwiper = new Swiper('.testimonialSwiper', {
            loop: true,
            autoplay: { delay: 5000, disableOnInteraction: false },
            pagination: { el: '.swiper-pagination', clickable: true },
            slidesPerView: 1,
            spaceBetween: 30,
            breakpoints: {
                768: { slidesPerView: 2 }
            }
        });

        setTimeout(function() {
            let toastEl = document.querySelector('.toast');
            if (toastEl) {
                let toast = new bootstrap.Toast(toastEl);
                toast.hide();
            }
        }, 2500);

        // Filter functionality for egg toggle
        let egglessMode = false;
        const products = document.querySelectorAll('.product-item');
        const eggToggle = document.getElementById('eggToggle');
        const eggText = document.getElementById('eggText');

        eggToggle.addEventListener('change', function() {
            egglessMode = this.checked;
            filterProducts();
            if (egglessMode) {
                eggText.classList.add('egg-active');
                eggText.innerText = "Eggless Mode ON";
            } else {
                eggText.classList.remove('egg-active');
                eggText.innerText = "Eggless Mode OFF";
            }
        });

        function filterProducts() {
            products.forEach(product => {
                let matchEgg = !egglessMode || product.dataset.egg === "eggless";
                product.style.display = matchEgg ? "block" : "none";
            });
        }
    </script>
</body>

</html>