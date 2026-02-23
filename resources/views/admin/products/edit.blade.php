@extends('admin.layouts.app')

@section('title', 'Edit Category - Blonde Bakery Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0 fw-bold">Edit Category</h1>
        <p class="text-muted">Update <strong>{{ $category->name }}</strong></p>
    </div>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Back to Categories
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label">Category Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name', $category->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Slug</label>
                        <input type="text" class="form-control bg-light" value="{{ $category->slug }}" readonly disabled>
                        <div class="form-text">Slug is auto-generated from the name. It will update when you change the name.</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="bg-light p-4 rounded-3">
                        <h5 class="serif fw-bold mb-3">Category Info</h5>
                        <p class="small mb-2">
                            <strong>Products:</strong> 
                            <span class="badge bg-gold-light text-dark">{{ $category->products_count ?? $category->products->count() ?? 0 }} Items</span>
                        </p>
                        <p class="small mb-0">
                            <strong>Created:</strong> {{ $category->created_at->format('M d, Y') }}
                        </p>
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">Cancel</a>
                <button type="submit" class="btn btn-gold px-5">
                    <i class="fas fa-save me-2"></i>Update Category
                </button>
            </div>
        </form>
    </div>
</div>
@endsection