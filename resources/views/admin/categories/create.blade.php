@extends('admin.layouts.app')

@section('title', 'Add Category - Blonde Bakery Admin')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h2 fw-bold" style="background: linear-gradient(135deg, var(--dark), var(--gold)); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
            Add New Category
        </h1>
        <p class="text-muted">Create a product category</p>
    </div>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Back to Categories
    </a>
</div>

<div class="card border-0 shadow-sm" style="border-radius: 20px;">
    <div class="card-body p-4">
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-bold">Category Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="e.g. Birthday Cakes" value="{{ old('name') }}" required>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                <div class="form-text">Slug will be auto-generated: e.g. birthday-cakes</div>
            </div>
            <button type="submit" class="btn btn-gold px-5">Save Category</button>
        </form>
    </div>
</div>
@endsection