@extends('layouts.app')

@section('title', $category->name . ' Collection')

@push('styles')
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        .category-header {
            background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), 
                        url('{{ $category->image ? asset('storage/'.$category->image) : 'https://images.unsplash.com/photo-1621303837174-89787a7d4729?q=80&w=1000' }}') center/cover;
            color: white;
            padding: 100px 0;
            margin-bottom: 60px;
            text-align: center;
        }
        .category-header h1 {
            font-size: 4rem;
            text-shadow: 2px 2px 8px rgba(0,0,0,0.3);
        }
        .product-card {
            border-radius: 16px;
            overflow: hidden;
            transition: 0.3s;
            background: white;
            box-shadow: 0 5px 20px rgba(0,0,0,0.03);
            height: 100%;
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(212,175,55,0.1);
        }
        .product-image {
            height: 250px;
            overflow: hidden;
        }
        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: 0.5s;
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
            font-size: 1.5rem;
            margin-bottom: 8px;
        }
        .product-price {
            color: var(--gold);
            font-weight: 600;
            font-size: 1.2rem;
            margin-bottom: 15px;
        }
        .btn-add {
            background: var(--dark);
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 50px;
            transition: 0.3s;
            width: 100%;
        }
        .btn-add:hover {
            background: var(--gold);
            color: var(--dark);
        }
    </style>
@endpush

@section('content')
    <div class="category-header" data-aos="fade-down">
        <h1 class="serif">{{ $category->name }}</h1>
        <p class="lead">{{ $category->products_count }} exquisite creations</p>
    </div>

    <div class="container pb-5">
        <div class="row g-4">
            @forelse($products as $product)
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                    <div class="product-card">
                        <div class="product-image">
                            <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" onerror="this.src='https://via.placeholder.com/400x300?text=Cake';">
                        </div>
                        <div class="product-info">
                            <h3>{{ $product->name }}</h3>
                            <div class="product-price">₹{{ number_format($product->price, 2) }}/kg</div>
                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-add">Add to Cart</button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted">No products in this category yet.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 800, once: true });
    </script>
@endpush