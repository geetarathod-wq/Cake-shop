@extends('admin.layout.app') {{-- Make sure this matches your layout filename --}}

@section('content')
<div class="main-content">
    <div class="top-bar">
        <div>
            <h1 class="serif mb-0" style="font-size: 2.5rem;">Product Categories</h1>
            <p class="text-muted small text-uppercase" style="letter-spacing: 2px;">Manage Bakery Sections</p>
        </div>
        <div class="user-profile">
            <button class="btn btn-outline-dark px-4 py-2" data-bs-toggle="modal" data-bs-target="#addCategoryModal" 
                    style="border-radius: 8px; border-color: var(--gold); color: var(--dark); font-weight: 500;">
                <i class="fas fa-plus me-2" style="color: var(--gold);"></i> Add New Category
            </button>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted text-uppercase small mb-1">Total Categories</h6>
                        <h3 class="serif mb-0">{{ $categories->count() }}</h3>
                    </div>
                    <div class="icon-box bg-gold-light">
                        <i class="fas fa-layer-group"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="table-container">
        <div class="d-flex justify-content-between align-items-center mb-4 px-3">
            <h5 class="serif mb-0" style="font-size: 1.5rem;">Existing Categories</h5>
        </div>
        
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Category Name</th>
                    <th>Slug</th>
                    <th>Products Count</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                <tr>
                    <td class="fw-bold text-muted">#{{ $category->id }}</td>
                    <td>
                        <span class="fw-semibold" style="color: var(--dark);">{{ $category->name }}</span>
                    </td>
                    <td><code class="small" style="color: var(--gold);">{{ $category->slug }}</code></td>
                    <td>{{ $category->products_count ?? 0 }} Items</td>
                    <td>
                        <span class="badge-status {{ $category->is_active ? 'bg-gold-light' : 'bg-light text-muted' }}">
                            {{ $category->is_active ? 'Active' : 'Draft' }}
                        </span>
                    </td>
                    <td class="text-end">
                        <button class="btn btn-link text-dark me-3 edit-category-btn" 
                                data-id="{{ $category->id }}" 
                                data-name="{{ $category->name }}"
                                data-bs-toggle="modal" 
                                data-bs-target="#editCategoryModal">
                            <i class="fas fa-pen-to-square"></i>
                        </button>
                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-link text-danger p-0" onclick="return confirm('Delete this category?')">
                                <i class="fas fa-trash-can"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5 text-muted">No categories found. Start by adding one!</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="serif modal-title" id="addCategoryModalLabel" style="font-size: 1.8rem;">Add New Category</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <div class="modal-body px-4">
                    <div class="mb-3">
                        <label for="name" class="form-label text-muted small text-uppercase fw-bold" style="letter-spacing: 1px;">Category Name</label>
                        <input type="text" name="name" id="name" 
                               class="form-control shadow-none @error('name') is-invalid @enderror" 
                               placeholder="e.g. Designer Cakes" 
                               style="border-color: #eee; padding: 12px; border-radius: 8px;" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal" style="border-radius: 8px;">Cancel</button>
                    <button type="submit" class="btn px-4" 
                            style="background-color: var(--gold); color: var(--dark); border-radius: 8px; fw-bold">
                        Create Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 15px; border: none;">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="serif modal-title" style="font-size: 1.8rem;">Edit Category</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <form id="editCategoryForm"> @csrf
                <div class="modal-body px-4">
                    <input type="hidden" id="edit_category_id" name="id">
                    
                    <div class="mb-3">
                        <label class="form-label text-muted small text-uppercase fw-bold">Category Name</label>
                        <input type="text" name="name" id="edit_name" class="form-control shadow-none" style="border-color: #eee; padding: 12px;" required>
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn px-4" style="background-color: var(--gold); color: var(--dark); font-weight: bold;">
                        Update Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('footer_script')
    <script>
        $(document).ready(function() {
            // Triggered when the edit icon is clicked
            $('.edit-category-btn').on('click', function() {
                const id = $(this).data('id'); 
                const name = $(this).data('name');
                
                // Fill the modal fields
                $('#edit_category_id').val(id);
                $('#edit_name').val(name);
                
                console.log("Preparing to edit ID:", id); 
            });

            // Triggered when 'Update Category' is clicked
            $('#editCategoryForm').on('submit', function(e) {
                e.preventDefault();
                
                var id = $('#edit_category_id').val();
                const name = $('#edit_name').val();
                
                if(!id || id === 'undefined') {
                    alert("Error: Category ID is missing from the hidden field.");
                    return;
                }
                const url = "{{ url('admin/categories/update') }}/" + id; // This will result in admin/categories/2

                $.ajax({
                    url: url,
                    type: 'POST', 
                    data: {
                        _token: "{{ csrf_token() }}",
                        name: name
                    },
                    // ... success and error handlers
                });
                location.reload();
            });
        });
    </script>
@endsection
