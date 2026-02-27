@extends('layouts.app')

@section('title', 'Search Results')

@push('styles')
    <style>
        .search-header {
            text-align: center;
            padding: 60px 0 30px;
        }
        .search-header h1 {
            font-size: 3rem;
            margin-bottom: 15px;
        }
        .search-header .divider {
            width: 80px;
            height: 3px;
            background: var(--gold);
            margin: 0 auto 20px;
        }
        .product-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 45px rgba(0,0,0,0.05);
            transition: all 0.3s;
            margin-bottom: 30px;
        }
        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 50px rgba(212,175,55,0.1);
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
        .product-info {
            padding: 20px;
            text-align: center;
        }
        .product-info h3 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.5rem;
            margin-bottom: 8px;
        }
        .product-info .price {
            color: var(--gold);
            font-weight: 600;
            font-size: 1.2rem;
            margin-bottom: 10px;
        }
        .btn-add {
            background: var(--dark);
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 50px;
            transition: 0.3s;
            width: 100%;
        }
        .btn-add:hover {
            background: var(--gold);
            color: var(--dark);
        }
        .no-results {
            text-align: center;
            padding: 80px 20px;
            color: #999;
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <div class="search-header" data-aos="fade-up">
            <h1 class="serif">Search Results</h1>
            <div class="divider"></div>
            @if(isset($query))
                <p class="text-muted">Showing results for "{{ $query }}"</p>
            @endif
        </div>

        @if($products->count() > 0)
            <div class="row g-4">
                @foreach($products as $product)
                    <div class="col-lg-4 col-md-6">
                        <div class="product-card">
                            <a href="{{ route('product.show', $product->slug) }}" class="text-decoration-none text-dark">
                                <div class="product-img-wrap">
                                    <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}"
                                         onerror="this.src='https://via.placeholder.com/500x500?text=Cake';">
                                </div>
                                <div class="product-info">
                                    <h3>{{ $product->name }}</h3>
                                    <p class="price">₹{{ number_format($product->price, 2) }}</p>
                                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn-add">Add to Cart</button>
                                    </form>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="no-results">
                <i class="fa-regular fa-face-frown fa-3x mb-3"></i>
                <h3 class="serif">No cakes found</h3>
                <p class="text-muted">Try searching with different keywords.</p>
                <a href="{{ route('categories.index') }}" class="btn-luxury mt-3">Browse Categories</a>
            </div>
        @endif
    </div>
@endsection