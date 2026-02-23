@extends('admin.layouts.app')

@section('title', 'Categories - Blonde Bakery Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0 fw-bold">Categories</h1>
        <p class="text-muted">Manage your cake categories</p>
    </div>
        <a href="{{ route('admin.products.create') }}" class="btn btn-gold">Add New Product</a>        <i class="fas fa-plus me-2"></i>Add New Category
    </a>
</div>

<div class="table-container">
    <div class="d-flex justify-content-between mb-4">
        <input type="text" id="searchInput" class="form-control" placeholder="Search categories..." style="width: 250px;">
    </div>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>CATEGORY NAME</th>
                    <th>SLUG</th>
                    <th>PRODUCTS</th>
                    <th>STATUS</th>
                    <th class="text-end">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                <tr>
                    <td class="fw-medium">#{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td><code>{{ $category->slug }}</code></td>
                    <td>
                        <span class="badge bg-gold-light text-dark px-3 py-2">
                            {{ $category->products_count ?? 0 }} Items
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-success bg-opacity-10 text-success px-3 py-2">Active</span>
                    </td>
                    <td class="text-end">
                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-sm btn-outline-primary me-2">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this category? All products in this category must be reassigned first.')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5">
                        <i class="fas fa-tags fs-2 text-muted mb-3 d-block"></i>
                        <h5 class="text-muted">No categories found</h5>
                        <a href="{{ route('admin.categories.create') }}" class="btn btn-gold mt-3">
                            <i class="fas fa-plus me-2"></i>Create Your First Category
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    document.getElementById('searchInput')?.addEventListener('keyup', function() {
        let value = this.value.toLowerCase();
        let rows = document.querySelectorAll('tbody tr');
        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(value) ? '' : 'none';
        });
    });
</script>
@endsection