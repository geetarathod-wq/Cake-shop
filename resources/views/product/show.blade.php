@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-6">
            <img src="{{ asset('storage/'.$product->image) }}" class="img-fluid rounded" alt="{{ $product->name }}">
        </div>
        <div class="col-md-6">
            <h1 class="serif">{{ $product->name }}</h1>
            <p class="text-muted">{{ $product->category->name }}</p>
            <h3 class="text-gold">₹{{ number_format($product->price, 2) }} / kg</h3>
            <p>{{ $product->description }}</p>
            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                @csrf
                <div class="row g-2">
                    <div class="col-4">
                        <select name="weight" class="form-select">
                            <option value="0.5">0.5 kg</option>
                            <option value="1" selected>1 kg</option>
                            <option value="1.5">1.5 kg</option>
                            <option value="2">2 kg</option>
                        </select>
                    </div>
                    <div class="col-4">
                        <input type="number" name="quantity" value="1" min="1" class="form-control">
                    </div>
                    <div class="col-4">
                        <button type="submit" class="btn btn-gold w-100">Add to Cart</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection