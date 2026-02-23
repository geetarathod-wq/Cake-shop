<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blonde Bakery | Haute Couture Cakes</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Primary Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Fallback CDN (if primary fails) -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.4.0/css/all.css">
    <link rel="icon" type="image/png" href="{{ asset('Fevicon_Cake.png') }}">
    
    <style>
        :root {
            --gold: #D4AF37;
            --cream: #F9F7F2;
            --dark: #1A1A1A;
            --white: #ffffff;
        }

        body { background-color: var(--cream); font-family: 'Montserrat', sans-serif; color: var(--dark); overflow-x: hidden; }
        .serif { font-family: 'Cormorant Garamond', serif; }
        .text-gold { color: var(--gold); }
        .letter-spacing-2 { letter-spacing: 2px; }
        .letter-spacing-3 { letter-spacing: 3px; }

        .navbar { 
            padding: 1.5rem 0; 
            transition: 0.4s cubic-bezier(0.4, 0, 0.2, 1); 
            z-index: 2000 !important; 
        }
        .navbar-brand { font-size: 1.6rem; letter-spacing: 5px; font-weight: 600; }
        .nav-link { font-weight: 500; transition: 0.3s; position: relative; }
        
        .hero-split { 
            position: relative; 
            height: 100vh; 
            display: flex; 
            align-items: center; 
            background: var(--cream); 
            z-index: 1; 
        }
        .hero-bg {
            position: absolute; top: 0; right: 0; width: 55%; height: 100%;
            background: url('https://images.unsplash.com/photo-1621303837174-89787a7d4729?q=80&w=1936') center/cover;
            clip-path: polygon(15% 0%, 100% 0, 100% 100%, 0% 100%);
            z-index: -1;
        }

        .custom-alert {
            position: fixed; top: 100px; left: 50%; transform: translateX(-50%);
            z-index: 2500; width: 90%; max-width: 500px; background: var(--dark);
            color: var(--white); border: 1px solid var(--gold); border-radius: 0;
            text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        .product-card { position: relative; margin-bottom: 80px; transition: 0.4s; }
        .product-img-wrap { 
            overflow: hidden; 
            height: 500px; 
            background-color: #eee;
            position: relative;
        }
        .product-img-wrap img { 
            width: 100%; height: 100%; object-fit: cover; object-position: center; 
            transition: 1.2s cubic-bezier(0.17, 0.67, 0.83, 0.67); 
        }
        .product-card:hover img { transform: scale(1.08); }
        
        .product-info-overlay {
            background: var(--white); padding: 30px; width: 85%; margin: -60px auto 0;
            position: relative; z-index: 5; text-align: center; box-shadow: 0 15px 45px rgba(0,0,0,0.05);
        }

        .btn-luxury {
            background: var(--dark); color: var(--white); border: 1px solid var(--dark);
            padding: 14px 35px; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 2px;
            transition: 0.4s; text-decoration: none; display: inline-block; cursor: pointer;
        }
        .btn-luxury:hover { background: transparent; color: var(--dark); }

        .btn-register-luxury {
            background: var(--dark); color: var(--white) !important;
            padding: 10px 25px; font-size: 0.7rem; letter-spacing: 2px;
            text-transform: uppercase; border: 1px solid var(--dark); transition: 0.3s;
        }
        .btn-register-luxury:hover { background: transparent; color: var(--dark) !important; }
        
        .floating-cart {
            position: fixed; top: 30px; right: 30px; z-index: 2100;
            width: 55px; height: 55px; background: var(--white); border-radius: 50%;
            display: flex; justify-content: center; align-items: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1); color: var(--dark); text-decoration: none;
        }
        .cart-badge { position: absolute; top: 0; right: 0; background: var(--gold); color: white; border-radius: 50%; padding: 2px 7px; font-size: 0.65rem; }

        .luxury-footer {
            background-color: var(--dark);
            color: var(--white);
            padding: 80px 0 40px;
            margin-top: 100px;
        }
        .footer-brand { font-size: 1.8rem; letter-spacing: 4px; color: var(--gold) !important; }
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
            font-weight: 300;
        }
        .footer-link:hover { color: var(--gold); transform: translateX(5px); }
        .social-icon {
            font-size: 1.1rem;
            color: var(--white);
            margin-right: 20px;
            transition: 0.3s;
            opacity: 0.7;
        }
        .social-icon:hover { opacity: 1; color: var(--gold); }
        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.05);
            margin-top: 60px;
            padding-top: 30px;
            font-size: 0.65rem;
            letter-spacing: 2px;
            color: rgba(255,255,255,0.4);
        }

        .dropdown-menu { border-radius: 0; padding: 15px 0; min-width: 220px; }
        .dropdown-item { padding: 8px 25px; transition: 0.2s; }
        .dropdown-item:hover { background-color: var(--cream); color: var(--gold); }
    </style>
</head>
<body>

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

    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand serif text-dark text-decoration-none" href="{{ route('home') }}">BLONDE BAKERY.</a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav align-items-center gap-2">
                    <li class="nav-item me-3">
                        <a class="nav-link text-uppercase small letter-spacing-2" href="{{ route('home') }}#collection">Collection</a>
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

    <section class="hero-split">
        <div class="hero-bg" data-aos="fade-left" data-aos-duration="1500"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-5" data-aos="fade-up">
                    <span class="text-gold text-uppercase small letter-spacing-3 d-block mb-3">Pune | Paris | Tokyo</span>
                    <h1 class="hero-title serif italic" style="font-size: 4.5rem; line-height: 1.1;">Elegance <br> You Can Taste.</h1>
                    <p class="lead opacity-75 my-4">Designing bespoke couture cakes that serve as the centerpiece for your most cherished celebrations.</p>
                    <a href="#collection" class="btn-luxury">View Collection</a>
                </div>
            </div>
        </div>
    </section>

    <section id="collection" class="py-5">
        <div class="container py-5">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="serif h1 italic">The Signature Series</h2>
                <div style="width: 50px; height: 2px; background: var(--gold); margin: 20px auto;"></div>
            </div>

            <div class="row">
                @forelse($products as $index => $product)
                <div class="col-lg-6 {{ $index % 2 != 0 ? 'mt-lg-5' : '' }}" data-aos="fade-up">
                    <div class="product-card px-3">
                        <div class="product-img-wrap">
                            <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid" alt="{{ $product->name }}" onerror="this.src='https://via.placeholder.com/500x500?text=Cake';">
                        </div>
                        <div class="product-info-overlay">
                            <span class="text-gold small text-uppercase letter-spacing-2">{{ $product->category->name ?? 'Couture' }}</span>
                            <h3 class="serif my-2">{{ $product->name }}</h3>
                            <p class="fw-bold mb-4">₹ {{ number_format($product->price, 2) }}</p>
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
        </div>
    </section>

    <footer class="luxury-footer">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-4" data-aos="fade-up">
                    <a href="#" class="footer-brand serif text-decoration-none d-block mb-3">BLONDE BAKERY.</a>
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
                    <a href="#collection" class="footer-link">Collection</a>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 1000, once: true });
        
        setTimeout(function() {
            let alert = document.querySelector('.custom-alert');
            if(alert) {
                let bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        }, 5000);   

        window.addEventListener('scroll', function() {
            const nav = document.querySelector('.navbar');
            if (window.scrollY > 80) {
                nav.style.background = '#F9F7F2';
                nav.style.padding = '0.8rem 0';
                nav.style.boxShadow = '0 10px 30px rgba(0,0,0,0.03)';
            } else {
                nav.style.background = 'transparent';
                nav.style.padding = '1.5rem 0';
                nav.style.boxShadow = 'none';
            }
        });
    </script>
</body>
</html>