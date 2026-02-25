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
            <div class="mb-3">
                <label class="form-label">Category Name *</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                       value="{{ old('name', $category->name) }}" required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                <div class="form-text">Slug will be auto‑updated: <code>{{ $category->slug }}</code></div>
            </div>
            <button type="submit" class="btn btn-gold">Update Category</button>
        </form>
    </div>
</div>
@endsection