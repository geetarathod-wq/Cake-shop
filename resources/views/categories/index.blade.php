@extends('layouts.app')

@section('content')

<div class="container py-4">

    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">🍰 Cake Categories</h2>
            <p class="text-muted mb-0">Explore all delicious cake collections</p>
        </div>

        <a href="{{ route('categories.create') }}" class="btn btn-primary px-4">
            + Add New Category
        </a>
    </div>

    <!-- Search Box -->
    <div class="mb-4">
        <input type="text" class="form-control shadow-sm"
               placeholder="🔍 Search categories...">
    </div>

    <!-- Categories Grid -->
    <div class="row g-4">

        @foreach($categories as $category)
        <div class="col-md-4 col-lg-3">
            <div class="card category-card h-100 shadow-sm border-0">

                <div class="card-body text-center">

                    <!-- Cake Icon -->
                    <div class="mb-3">
                        <div class="category-icon">
                            🎂
                        </div>
                    </div>

                    <!-- Category Name -->
                    <h5 class="fw-bold mb-1">
                        {{ $category->name }}
                    </h5>

                    <!-- Slug -->
                    <p class="text-muted small mb-2">
                        {{ $category->slug }}
                    </p>

                    <!-- Product Count -->
                    <span class="badge bg-success mb-3">
                        {{ $category->products_count ?? 0 }} Items
                    </span>

                    <!-- Status -->
                    <div class="mb-3">
                        <span class="badge bg-info">
                            {{ $category->status ? 'Active' : 'Inactive' }}
                        </span>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-center gap-2">
                        <a href="{{ route('categories.edit', $category->id) }}"
                           class="btn btn-sm btn-outline-primary">
                            Edit
                        </a>

                        <form action="{{ route('categories.destroy', $category->id) }}"
                              method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="btn btn-sm btn-outline-danger">
                                Delete
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        @endforeach

    </div>

</div>


<!-- Custom Styling -->
<style>
.category-card {
    border-radius: 15px;
    transition: all 0.3s ease;
}

.category-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

.category-icon {
    font-size: 40px;
    background: linear-gradient(135deg, #ff9a9e, #fad0c4);
    width: 70px;
    height: 70px;
    line-height: 70px;
    margin: auto;
    border-radius: 50%;
    color: white;
}
</style>

@endsection