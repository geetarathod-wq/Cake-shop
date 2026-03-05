@extends('layouts.app')

@section('content')
<div class="hero-section">
    <h1>Delicious Cakes Delivered Fast!</h1>
    <p class="lead">Order freshly baked cakes for any occasion.</p>
    <a href="#menu" class="btn btn-custom btn-lg">View Menu</a>
</div>

<div class="container mt-5" id="menu">
    <h2 class="text-center mb-4">Our Best Sellers</h2>
    <div class="row">
        @foreach($cakes as $cake)
        <div class="col-md-3 mb-4">
            <div class="card cake-card shadow-sm h-100">
                <img src="{{ $cake->image_url }}" class="card-img-top" alt="{{ $cake->name }}">
                <div class="card-body text-center">
                    <h5 class="card-title">{{ $cake->name }}</h5>
                    <p class="text-muted">${{ $cake->price }}</p>
                    <a href="{{ route('add.to.cart', $cake->id) }}" class="btn btn-custom w-100">Add to Cart</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection