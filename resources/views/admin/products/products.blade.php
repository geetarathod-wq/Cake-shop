@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 style="color: #2C1810;">Manage Products</h2>
    <a href="{{ route('products.create') }}" class="btn" style="background: #D4AF37; color: white;">+ Add Cake</a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead style="background: #2C1810; color: #D4AF37;">
                <tr>
                    <th class="ps-4">Image</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th class="text-center">Debug Info</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr class="align-middle">
                    <td class="ps-4">
                        <div style="width: 80px; height: 80px; overflow: hidden; border: 1px solid #eee;">
                            <img src="{{ asset('storage/' . $product->image) }}" 
                                 alt="{{ $product->name }}" 
                                 style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                    </td>
                    <td class="fw-bold">{{ $product->name }}</td>
                    <td>
                        <span class="badge bg-light text-dark border">
                            {{ $product->category->name ?? 'Uncategorized' }}
                        </span>
                    </td>
                    <td>₹{{ number_format($product->price, 2) }}</td>
                    <td>
                        <small class="text-muted d-block" style="font-size: 0.7rem;">
                            <strong>DB Value:</strong> {{ $product->image }}
                        </small>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@if($products->isEmpty())
<div class="text-center py-5">
    <p class="text-muted italic serif">Your atelier is currently empty. Add your first masterpiece!</p>
</div>
@endif

@endsection