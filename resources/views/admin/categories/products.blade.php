@extends('admin.layouts.app')

@section('title', $category->name . ' Collection')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 fw-bold">{{ $category->name }} Collection</h1>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Back to Categories
    </a>
</div>

<div class="row">
    @forelse($products as $product)
    <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm">
            <img src="{{ asset('storage/' . $product->image) }}" 
                 class="card-img-top" 
                 alt="{{ $product->name }}" 
                 style="height: 200px; object-fit: cover;"
                 onerror="this.src='{{ asset('images/placeholder-cake.png') }}';">
            <div class="card-body">
                <h5 class="card-title">{{ $product->name }}</h5>
                <p class="card-text text-muted">{{ $product->category->name ?? 'Uncategorized' }}</p>
                <p class="fw-bold">₹{{ number_format($product->price, 2) }}</p>
                <span class="badge bg-{{ $product->is_active ? 'success' : 'secondary' }}">
                    {{ $product->is_active ? 'Active' : 'Inactive' }}
                </span>
            </div>
            <div class="card-footer bg-white border-0">
                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this product?')">Delete</button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5">
        <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
        <p class="text-muted">No products in this category.</p>
        <a href="{{ route('admin.products.create') }}" class="btn btn-gold">Add New Product</a>
    </div>
    @endforelse
</div>
@endsection