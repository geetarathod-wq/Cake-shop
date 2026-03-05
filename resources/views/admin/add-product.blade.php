<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label>Cake Name</label>
        <input type="text" name="name" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Base Price (for 1 KG)</label>
        <div class="input-group">
            <span class="input-group-text">₹</span>
            <input type="number" name="price" class="form-control" placeholder="500" required>
        </div>
    </div>

    <div class="mb-3">
        <label>Cake Image</label>
        <input type="file" name="image" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary">Add Cake to Shop</button>
</form>