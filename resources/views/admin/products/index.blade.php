@extends('admin.layouts.app')

@section('title', 'Products - Blonde Bakery Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 fw-bold">Products</h1>
    <a href="{{ route('admin.products.create') }}" class="btn btn-gold">
        <i class="fas fa-plus me-2"></i>Add New Product
    </a>
</div>

<div class="table-container">
    <table class="table">
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
            <tr>
                <td>
                    <img src="{{ asset('storage/'.$product->image) }}" width="50" height="50" style="object-fit: cover;" alt="">
                </td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->category->name ?? 'Uncategorized' }}</td>
                <td>₹{{ number_format($product->price, 2) }}</td>
                <td>
                    <span class="badge bg-{{ $product->is_active ? 'success' : 'secondary' }}">
                        {{ $product->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete?')">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center">No products found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection