@extends('layouts.app')

@section('title', $category->name . ' - Blonde Bakery')

@push('styles')
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        /* Category header */
        .category-header {
            text-align: center;
            padding: 60px 0 30px;
        }
        .category-header h1 {
            font-size: 3.5rem;
            margin-bottom: 15px;
            font-family: 'Cormorant Garamond', serif;
        }
        .divider {
            width: 80px;
            height: 3px;
            background: var(--gold);
            margin: 0 auto 20px;
        }

        /* Back button */
        .back-to-collections {
            position: absolute;
            top: 100px;
            left: 30px;
            z-index: 10;
        }
        .back-to-collections a {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: var(--dark);
            font-size: 0.9rem;
            background: white;
            padding: 8px 15px;
            border-radius: 50px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            transition: 0.3s;
        }
        .back-to-collections a:hover {
            background: var(--gold);
            color: white;
        }

        /* Product grid */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 30px;
            margin-top: 40px;
            margin-bottom: 60px;
        }

        /* Product card */
        .product-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.03);
            transition: transform 0.3s, box-shadow 0.3s;
            position: relative;
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(212,175,55,0.1);
        }

        .product-image {
            height: 240px;
            overflow: hidden;
            background: #f5f5f5;
        }
        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s;
        }
        .product-card:hover .product-image img {
            transform: scale(1.05);
        }

        .product-info {
            padding: 20px;
            text-align: center;
        }

        .product-info h3 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.6rem;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        /* Food icon styles (exactly as before) */
        .food-icon {
            width: 16px;
            height: 16px;
            border: 2px solid;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 3px;
            background: white;
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

        .product-price {
            font-size: 1.4rem;
            font-weight: 500;
            color: var(--dark);
            margin: 10px 0 15px;
        }

        .add-to-cart-btn {
            background: var(--gold);
            color: var(--dark);
            border: none;
            border-radius: 50px;
            padding: 10px 30px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: 0.3s;
            cursor: pointer;
            width: 100%;
            max-width: 200px;
            margin: 0 auto;
        }
        .add-to-cart-btn:hover {
            background: #c9a53b;
            transform: scale(1.02);
        }

        .no-products {
            text-align: center;
            padding: 50px;
            color: #999;
            font-size: 1.2rem;
        }
    </style>
@endpush

@section('content')
    <div class="container position-relative">
        <!-- Back button -->
        <div class="back-to-collections">
            <a href="{{ route('categories.index') }}">
                <i class="fas fa-arrow-left me-2"></i> Back to Collections
            </a>
        </div>

        <!-- Category header -->
        <div class="category-header" data-aos="fade-up">
            <h1>{{ $category->name }}</h1>
            <div class="divider"></div>
            <p class="text-muted">{{ $category->description ?? 'Discover our exquisite creations' }}</p>
        </div>

        <!-- Products grid -->
        @if($products->count() > 0)
            <div class="products-grid" data-aos="fade-up">
                @foreach($products as $product)
                    <div class="product-card">
                        <div class="product-image">
                            @php
                                $imagePath = $product->image ? 'storage/'.$product->image : null;
                                $imageExists = $imagePath && file_exists(public_path($imagePath));
                            @endphp
                            <img src="{{ $imageExists ? asset($imagePath) : asset('images/product-placeholder.jpg') }}"
                                 onerror="this.onerror=null; this.src='{{ asset('images/product-placeholder.jpg') }}';"
                                 alt="{{ $product->name }}">
                        </div>
                        <div class="product-info">
                            <h3>
                                {{ $product->name }}
                                {{-- Food icon indicator --}}
                                @if($product->is_eggless)   {{-- adjust field name as needed --}}
                                    <span class="food-icon veg" title="Eggless"></span>
                                @else
                                    <span class="food-icon non-veg" title="Contains Egg"></span>
                                @endif
                            </h3>
                            <div class="product-price">
                                ₤{{ number_format($product->price, 2) }}/kg
                            </div>
                            <form action="{{ route('cart.add', $product) }}" method="POST">
                                @csrf
                                <button type="submit" class="add-to-cart-btn">Add to Cart</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="no-products">
                <i class="fa-regular fa-face-frown fa-2x mb-3"></i>
                <p>No products found in this category.</p>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 800, once: true });
    </script>
@endpush