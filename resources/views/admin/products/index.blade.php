@extends('admin.layouts.app')

@section('title', 'Products - Blonde Bakery Admin')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0 fw-bold">Product Collections</h1>
        <p class="text-muted">Manage your cake products</p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="btn btn-gold">
        <i class="fas fa-plus me-2"></i>Add New Product
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="table-container">

    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>PRODUCT</th>
                    <th>CATEGORY</th>
                    <th>PRICE</th>
                    <th>IMAGE</th>
                    <th>STATUS</th>
                    <th class="text-end">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>

                    <!-- Product Name -->
                    <td>
                        <a href="{{ route('admin.products.edit', $product->id) }}"
                           class="text-decoration-none text-dark">
                            <div class="fw-bold">{{ $product->name }}</div>
                            <small class="text-muted">{{ $product->slug }}</small>
                        </a>
                    </td>

                    <!-- Category -->
                    <td>
                        {{ $product->category->name ?? '—' }}
                    </td>

                    <!-- Price -->
                    <td>
                        ₹{{ number_format($product->price, 2) }}
                    </td>

                    <!-- Image -->
                    <td>
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}"
                                 alt="{{ $product->name }}"
                                 style="height:60px; width:60px; object-fit:cover; border-radius:8px;">
                        @else
                            <span class="text-muted">No Image</span>
                        @endif
                    </td>

                    <!-- Status -->
                    <td>
                        @if($product->is_active)
                            <span class="badge bg-success bg-opacity-10 text-success px-3 py-2">
                                Active
                            </span>
                        @else
                            <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2">
                                Inactive
                            </span>
                        @endif
                    </td>

                    <!-- Actions -->
                    <td class="text-end">
                        <a href="{{ route('admin.products.edit', $product->id) }}"
                           class="btn btn-sm btn-outline-primary me-2">
                            <i class="fas fa-edit"></i>
                        </a>

                        <form action="{{ route('admin.products.destroy', $product->id) }}"
                              method="POST"
                              class="d-inline">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="btn btn-sm btn-outline-danger"
                                    onclick="return confirm('Delete this product?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5">
                        <i class="fas fa-birthday-cake fs-2 text-muted mb-3 d-block"></i>
                        <h5 class="text-muted">No products found</h5>
                        <a href="{{ route('admin.products.create') }}" class="btn btn-gold mt-3">
                            <i class="fas fa-plus me-2"></i>Create Your First Product
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection