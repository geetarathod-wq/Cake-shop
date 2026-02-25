<table class="table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Price (1 KG)</th> <th>Category</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
        <tr>
            <td>{{ $product->name }}</td>
            <td>₹{{ $product->price }}</td> <td>{{ $product->category->name ?? 'None' }}</td>
            <td>
                </td>
        </tr>
        @endforeach
    </tbody>
</table>