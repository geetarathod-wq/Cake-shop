@extends('admin.layouts.app')

@section('title', 'Edit Walk-In Order - Blonde Bakery Admin')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 fw-bold">Edit Walk-In Order #{{ $walkInOrder->id }}</h1>
        <a href="{{ route('admin.walkin-orders.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to List
        </a>
    </div>

    <form action="{{ route('admin.walkin-orders.update', ['walkin_order' => $walkInOrder->id]) }}" method="POST" id="orderForm">        @csrf
        @method('PUT')

        <div class="row">
            <!-- Customer Details -->
            <div class="col-md-6">
                <div class="card modern-card mb-4">
                    <div class="card-header bg-transparent">
                        <h5 class="mb-0 fw-bold">Customer Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="customer_name" class="form-label">Customer Name *</label>
                            <input type="text" class="form-control @error('customer_name') is-invalid @enderror" id="customer_name" name="customer_name" value="{{ old('customer_name', $walkInOrder->customer_name) }}" required>
                            @error('customer_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number *</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $walkInOrder->phone) }}" required>
                            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $walkInOrder->email) }}">
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="2">{{ old('address', $walkInOrder->address) }}</textarea>
                            @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Details -->
            <div class="col-md-6">
                <div class="card modern-card mb-4">
                    <div class="card-header bg-transparent">
                        <h5 class="mb-0 fw-bold">Order Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="order_date" class="form-label">Order Date *</label>
                            <input type="date" class="form-control @error('order_date') is-invalid @enderror" id="order_date" name="order_date" value="{{ old('order_date', $walkInOrder->order_date->format('Y-m-d')) }}" required>
                            @error('order_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="delivery_date" class="form-label">Delivery Date *</label>
                            <input type="date" class="form-control @error('delivery_date') is-invalid @enderror" id="delivery_date" name="delivery_date" value="{{ old('delivery_date', $walkInOrder->delivery_date->format('Y-m-d')) }}" required>
                            @error('delivery_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="delivery_slot" class="form-label">Delivery Slot *</label>
                            <select class="form-select @error('delivery_slot') is-invalid @enderror" id="delivery_slot" name="delivery_slot" required>
                                <option value="morning" {{ old('delivery_slot', $walkInOrder->delivery_slot) == 'morning' ? 'selected' : '' }}>Morning</option>
                                <option value="afternoon" {{ old('delivery_slot', $walkInOrder->delivery_slot) == 'afternoon' ? 'selected' : '' }}>Afternoon</option>
                                <option value="evening" {{ old('delivery_slot', $walkInOrder->delivery_slot) == 'evening' ? 'selected' : '' }}>Evening</option>
                            </select>
                            @error('delivery_slot') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="order_type" class="form-label">Order Type *</label>
                            <select class="form-select @error('order_type') is-invalid @enderror" id="order_type" name="order_type" required>
                                <option value="pickup" {{ old('order_type', $walkInOrder->order_type) == 'pickup' ? 'selected' : '' }}>Pickup</option>
                                <option value="delivery" {{ old('order_type', $walkInOrder->order_type) == 'delivery' ? 'selected' : '' }}>Delivery</option>
                            </select>
                            @error('order_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="admin_note" class="form-label">Admin Note</label>
                            <textarea class="form-control @error('admin_note') is-invalid @enderror" id="admin_note" name="admin_note" rows="2">{{ old('admin_note', $walkInOrder->admin_note) }}</textarea>
                            @error('admin_note') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Details -->
        <div class="row">
            <div class="col-md-6">
                <div class="card modern-card mb-4">
                    <div class="card-header bg-transparent">
                        <h5 class="mb-0 fw-bold">Payment Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="payment_method" class="form-label">Payment Method *</label>
                            <select class="form-select @error('payment_method') is-invalid @enderror" id="payment_method" name="payment_method" required>
                                <option value="cash" {{ old('payment_method', $walkInOrder->payment_method) == 'cash' ? 'selected' : '' }}>Cash</option>
                                <option value="upi" {{ old('payment_method', $walkInOrder->payment_method) == 'upi' ? 'selected' : '' }}>UPI</option>
                                <option value="card" {{ old('payment_method', $walkInOrder->payment_method) == 'card' ? 'selected' : '' }}>Card</option>
                            </select>
                            @error('payment_method') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="payment_status" class="form-label">Payment Status *</label>
                            <select class="form-select @error('payment_status') is-invalid @enderror" id="payment_status" name="payment_status" required>
                                <option value="pending" {{ old('payment_status', $walkInOrder->payment_status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="paid" {{ old('payment_status', $walkInOrder->payment_status) == 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="failed" {{ old('payment_status', $walkInOrder->payment_status) == 'failed' ? 'selected' : '' }}>Failed</option>
                            </select>
                            @error('payment_status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-md-6">
                <div class="card modern-card mb-4">
                    <div class="card-header bg-transparent">
                        <h5 class="mb-0 fw-bold">Order Summary</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <span class="fw-bold" id="summary-subtotal">₹{{ number_format($walkInOrder->subtotal, 2) }}</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <span>Total:</span>
                            <span class="fw-bold fs-5" id="summary-total">₹{{ number_format($walkInOrder->subtotal, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Section -->
        <div class="card modern-card mb-4">
            <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">Products</h5>
                <button type="button" class="btn btn-sm btn-gold" id="addProductRow">
                    <i class="fas fa-plus me-1"></i>Add Product
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="productsTable">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="productRows">
                            @foreach($walkInOrder->items as $index => $item)
                            <tr>
                                <td>
                                    <select name="products[{{ $index }}][product_id]" class="form-select product-select" required>
                                        <option value="">Select Product</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}" data-price="{{ $product->price }}" {{ $item->product_id == $product->id ? 'selected' : '' }}>
                                                {{ $product->name }} (₹{{ $product->price }})
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="number" name="products[{{ $index }}][quantity]" class="form-control product-qty" value="{{ $item->quantity }}" min="1" required>
                                </td>
                                <td>
                                    <span class="product-price" data-price="{{ $item->price }}">₹{{ number_format($item->price, 2) }}</span>
                                </td>
                                <td>
                                    <span class="product-subtotal">₹{{ number_format($item->subtotal, 2) }}</span>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-outline-danger remove-product-row">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2">
            <button type="submit" class="btn btn-gold rounded-full px-4">Update Order</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    const products = @json($products);

    function updateSubtotal() {
        let subtotal = 0;
        document.querySelectorAll('#productRows tr').forEach(row => {
            const qty = row.querySelector('.product-qty')?.value || 0;
            const price = row.querySelector('.product-price')?.dataset.price || 0;
            const rowSubtotal = qty * price;
            row.querySelector('.product-subtotal').textContent = '₹' + rowSubtotal.toFixed(2);
            subtotal += rowSubtotal;
        });
        document.getElementById('summary-subtotal').textContent = '₹' + subtotal.toFixed(2);
        document.getElementById('summary-total').textContent = '₹' + subtotal.toFixed(2);
    }

    document.getElementById('addProductRow').addEventListener('click', function() {
        const tbody = document.getElementById('productRows');
        const index = tbody.children.length;
        let options = '<option value="">Select Product</option>';
        products.forEach(p => {
            options += `<option value="${p.id}" data-price="${p.price}">${p.name} (₹${p.price})</option>`;
        });

        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>
                <select name="products[${index}][product_id]" class="form-select product-select" required>
                    ${options}
                </select>
            </td>
            <td>
                <input type="number" name="products[${index}][quantity]" class="form-control product-qty" value="1" min="1" required>
            </td>
            <td>
                <span class="product-price" data-price="0">₹0.00</span>
            </td>
            <td>
                <span class="product-subtotal">₹0.00</span>
            </td>
            <td>
                <button type="button" class="btn btn-sm btn-outline-danger remove-product-row">
                    <i class="fas fa-times"></i>
                </button>
            </td>
        `;
        tbody.appendChild(tr);

        tr.querySelector('.product-select').addEventListener('change', function() {
            const opt = this.options[this.selectedIndex];
            const price = opt.dataset.price || 0;
            const priceSpan = tr.querySelector('.product-price');
            priceSpan.dataset.price = price;
            priceSpan.textContent = '₹' + parseFloat(price).toFixed(2);
            updateSubtotal();
        });

        tr.querySelector('.product-qty').addEventListener('input', updateSubtotal);
        tr.querySelector('.remove-product-row').addEventListener('click', function() {
            tr.remove();
            updateSubtotal();
        });
    });

    // Attach events to existing rows
    document.querySelectorAll('#productRows tr').forEach(row => {
        row.querySelector('.product-select').addEventListener('change', function() {
            const opt = this.options[this.selectedIndex];
            const price = opt.dataset.price || 0;
            const priceSpan = row.querySelector('.product-price');
            priceSpan.dataset.price = price;
            priceSpan.textContent = '₹' + parseFloat(price).toFixed(2);
            updateSubtotal();
        });
        row.querySelector('.product-qty').addEventListener('input', updateSubtotal);
        row.querySelector('.remove-product-row').addEventListener('click', function() {
            row.remove();
            updateSubtotal();
        });
    });

    window.addEventListener('load', updateSubtotal);
</script>
@endpush