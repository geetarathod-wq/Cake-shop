@extends('admin.layouts.app')

@section('title', 'New Walk-In Order - Blonde Bakery Admin')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 fw-bold">New Walk-In Order</h1>
        <a href="{{ route('admin.walkin-orders.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to List
        </a>
    </div>

    <form action="{{ route('admin.walkin-orders.store') }}" method="POST" id="orderForm">
        @csrf

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
                            <input type="text" class="form-control @error('customer_name') is-invalid @enderror" id="customer_name" name="customer_name" value="{{ old('customer_name') }}" required>
                            @error('customer_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number *</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" required>
                            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}">
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="2">{{ old('address') }}</textarea>
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
                            <input type="date" class="form-control @error('order_date') is-invalid @enderror" id="order_date" name="order_date" value="{{ old('order_date', now()->format('Y-m-d')) }}" required>
                            @error('order_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="delivery_date" class="form-label">Delivery Date *</label>
                            <input type="date" class="form-control @error('delivery_date') is-invalid @enderror" id="delivery_date" name="delivery_date" value="{{ old('delivery_date', now()->addDay()->format('Y-m-d')) }}" required>
                            @error('delivery_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="delivery_slot" class="form-label">Delivery Slot *</label>
                            <select class="form-select @error('delivery_slot') is-invalid @enderror" id="delivery_slot" name="delivery_slot" required>
                                <option value="morning" {{ old('delivery_slot') == 'morning' ? 'selected' : '' }}>Morning</option>
                                <option value="afternoon" {{ old('delivery_slot') == 'afternoon' ? 'selected' : '' }}>Afternoon</option>
                                <option value="evening" {{ old('delivery_slot') == 'evening' ? 'selected' : '' }}>Evening</option>
                            </select>
                            @error('delivery_slot') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="order_type" class="form-label">Order Type *</label>
                            <select class="form-select @error('order_type') is-invalid @enderror" id="order_type" name="order_type" required>
                                <option value="pickup" {{ old('order_type') == 'pickup' ? 'selected' : '' }}>Pickup</option>
                                <option value="delivery" {{ old('order_type') == 'delivery' ? 'selected' : '' }}>Delivery</option>
                            </select>
                            @error('order_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="admin_note" class="form-label">Admin Note</label>
                            <textarea class="form-control @error('admin_note') is-invalid @enderror" id="admin_note" name="admin_note" rows="2">{{ old('admin_note') }}</textarea>
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
                                <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                                <option value="upi" {{ old('payment_method') == 'upi' ? 'selected' : '' }}>UPI</option>
                                <option value="card" {{ old('payment_method') == 'card' ? 'selected' : '' }}>Card</option>
                            </select>
                            @error('payment_method') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="payment_status" class="form-label">Payment Status *</label>
                            <select class="form-select @error('payment_status') is-invalid @enderror" id="payment_status" name="payment_status" required>
                                <option value="pending" {{ old('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="paid" {{ old('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="failed" {{ old('payment_status') == 'failed' ? 'selected' : '' }}>Failed</option>
                            </select>
                            @error('payment_status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary (will be filled by JS) -->
            <div class="col-md-6">
                <div class="card modern-card mb-4">
                    <div class="card-header bg-transparent">
                        <h5 class="mb-0 fw-bold">Order Summary</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <span class="fw-bold" id="summary-subtotal">₹0.00</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <span>Total:</span>
                            <span class="fw-bold fs-5" id="summary-total">₹0.00</span>
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
                            <!-- Rows will be added here dynamically -->
                        </tbody>
                    </table>
                </div>
                <p class="text-muted small mb-0">Select products and quantities. Subtotal updates automatically.</p>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2">
            <button type="reset" class="btn btn-outline-secondary rounded-full px-4">Reset</button>
            <button type="submit" class="btn btn-gold rounded-full px-4">Save Walk-In Order</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    // Product data from server (JSON)
    const products = @json($products);

    // Keep track of selected products to avoid duplicates
    let selectedProductIds = [];

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

    function addProductRow(productId = null) {
        const tbody = document.getElementById('productRows');
        const rowCount = tbody.children.length;
        const index = rowCount; // for unique names

        // Build product options
        let options = '<option value="">Select Product</option>';
        products.forEach(p => {
            const selected = (productId && p.id == productId) ? 'selected' : '';
            options += `<option value="${p.id}" data-price="${p.price}" ${selected}>${p.name} (₹${p.price})</option>`;
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

        // Attach event listeners
        const select = tr.querySelector('.product-select');
        const qtyInput = tr.querySelector('.product-qty');
        const priceSpan = tr.querySelector('.product-price');

        select.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const price = selectedOption.dataset.price || 0;
            priceSpan.dataset.price = price;
            priceSpan.textContent = '₹' + parseFloat(price).toFixed(2);
            updateSubtotal();
        });

        qtyInput.addEventListener('input', updateSubtotal);

        tr.querySelector('.remove-product-row').addEventListener('click', function() {
            tr.remove();
            updateSubtotal();
        });

        // If productId provided, trigger change to set price
        if (productId) {
            select.dispatchEvent(new Event('change'));
        }
    }

    document.getElementById('addProductRow').addEventListener('click', function() {
        addProductRow();
    });

    // Add at least one row on page load
    window.addEventListener('load', function() {
        addProductRow();
    });
</script>
@endpush