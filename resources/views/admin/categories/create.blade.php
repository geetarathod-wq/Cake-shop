@extends('admin.layouts.app')

@section('title', 'Add Category - Blonde Bakery Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0 fw-bold">Add New Category</h1>
        <p class="text-muted">Create a product category</p>
    </div>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Back to Categories
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Category Name *</label>
                <input type="text" name="name" class="form-control" placeholder="e.g. Birthday Cakes" required>
                <div class="form-text">Slug will be auto-generated: e.g. birthday-cakes</div>
            </div>
            <button type="submit" class="btn btn-gold">Save Category</button>
        </form>
    </div>
</div>
@endsection
