@extends('admin.layouts.app')

@section('title', $category->name . ' Collection - Blonde Bakery Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0 fw-bold">{{ $category->name }} Collection</h1>
        <p class="text-muted">Products in this category</p>
    </div>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Back to Categories
    </a>
</div>

<div class="table-container">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td class="fw-medium">{{ $product->name }}</td>
                    <td>₹{{ number_format($product->price, 2) }}</td>
                    <td>
                        <span class="badge bg-success bg-opacity-10 text-success px-3 py-2">IN STOCK</span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center py-5">
                        <i class="fas fa-box-open fs-2 text-muted mb-3 d-block"></i>
                        <h5 class="text-muted">No products in this category</h5>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection