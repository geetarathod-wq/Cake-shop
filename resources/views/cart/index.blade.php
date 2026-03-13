<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Atelier Bag | Blonde Bakery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('Fevicon_Cake.png') }}">
    {{-- jQuery is still included because it's used by the Razorpay handler – you can replace that later if you wish --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        :root { --gold: #D4AF37; --cream: #F9F7F2; --dark: #1A1A1A; }
        body { background-color: var(--cream); font-family: 'Montserrat', sans-serif; }
        .serif { font-family: 'Cormorant Garamond', serif; font-style: italic; }
        .btn-luxury { background: var(--dark); color: white; border: none; letter-spacing: 2px; text-transform: uppercase; font-size: 0.8rem; padding: 12px; transition: 0.3s; text-decoration: none; width: 100%; }
        .btn-luxury:hover { background: var(--gold); color: var(--dark); }
        .btn-outline-luxury { background: transparent; border: 1px solid var(--dark); color: var(--dark); }
        .btn-outline-luxury:hover { background: var(--dark); color: white; }
        .cart-item-img { width: 80px; height: 80px; object-fit: cover; border-radius: 8px; }
        .qty-input { width: 45px; text-align: center; border: none; background: transparent; font-weight: bold; }
        .qty-btn { cursor: pointer; color: var(--dark); transition: 0.2s; }
        .qty-btn:hover { color: var(--gold); }
        .weight-select { width: 80px; padding: 4px; border-radius: 4px; border: 1px solid #ddd; }
        .checkout-form { background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.03); }
        .form-control:focus { border-color: var(--gold); box-shadow: 0 0 0 0.2rem rgba(212,175,55,0.1); }
    </style>
    {{-- CSRF token meta tag – required for fetch requests --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

<div class="container py-5">
    <h1 class="serif display-5 text-center mb-5">Your Selection</h1>

    @php
        $cart = $cart ?? session('cart', []);
        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['weight'] * $item['quantity'];
        }
    @endphp

    @if(count($cart) > 0)
        <div class="row">
            <!-- Cart Items -->
            <div class="col-lg-7 mb-4">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr class="text-uppercase small letter-spacing-2">
                                <th colspan="2">Product</th>
                                <th>Weight</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="cart-items-body">
                            @foreach($cart as $id => $details)
                                @php
                                    $subtotal = $details['price'] * $details['weight'] * $details['quantity'];
                                @endphp
                                <tr data-id="{{ $id }}" data-item-id="{{ $details['id'] ?? '' }}">
                                    <td style="width: 100px;">
                                        <img src="{{ asset('storage/'.$details['image']) }}" 
                                            class="cart-item-img" 
                                            alt="{{ $details['name'] }}"
                                            onerror="this.onerror=null; this.parentElement.innerHTML='<div style=\'width:80px;height:80px;background:#f8f8f8;border-radius:8px;display:flex;align-items:center;justify-content:center;\'><i class=\'fas fa-cake-candles fs-3 text-muted\'></i></div>';">
                                    </td>
                                    <td>
                                        <h6 class="mb-0 fw-bold">{{ $details['name'] }}</h6>
                                        <small class="text-muted">₹{{ number_format($details['price'], 2) }} / kg</small>
                                    </td>
                                    <td>
                                        <select class="form-select weight-select update-weight">
                                            <option value="0.5" {{ $details['weight'] == 0.5 ? 'selected' : '' }}>0.5 kg</option>
                                            <option value="1" {{ $details['weight'] == 1 ? 'selected' : '' }}>1 kg</option>
                                            <option value="1.5" {{ $details['weight'] == 1.5 ? 'selected' : '' }}>1.5 kg</option>
                                            <option value="2" {{ $details['weight'] == 2 ? 'selected' : '' }}>2 kg</option>
                                        </select>
                                    </td>
                                    <td style="width: 120px;">
                                        <div class="d-flex align-items-center border p-1" style="width: fit-content; background: white;">
                                            <span class="qty-btn px-2 update-cart-minus"><i class="fa fa-minus small"></i></span>
                                            <input type="number" value="{{ $details['quantity'] }}" class="qty-input quantity" readonly>
                                            <span class="qty-btn px-2 update-cart-plus"><i class="fa fa-plus small"></i></span>
                                        </div>
                                    </td>
                                    <td class="serif fw-bold item-subtotal">₹{{ number_format($subtotal, 2) }}</td>
                                    <td class="text-end">
                                        <button class="btn btn-sm text-danger remove-from-cart">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    <a href="{{ route('home') }}" class="btn btn-outline-luxury px-4">
                        <i class="fas fa-arrow-left me-2"></i>Continue Shopping
                    </a>
                </div>
            </div>

            <!-- Checkout Form -->
            <div class="col-lg-5">
                <div class="checkout-form">
                    <h4 class="serif mb-4">Checkout</h4>
                    <form id="checkoutForm" action="{{ route('checkout.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" name="name" class="form-control mb-2" placeholder="Full Name" required value="{{ auth()->user()->name ?? '' }}">
                                <input type="email" name="email" class="form-control mb-2" placeholder="Email" required value="{{ auth()->user()->email ?? '' }}">
                                <input type="text" name="phone" class="form-control mb-2" placeholder="Phone" required>
                            </div>
                            <div class="col-md-6">
                                <textarea name="address" class="form-control mb-2" placeholder="Address" required></textarea>
                                <input type="date" name="delivery_date" class="form-control mb-2" required min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Payment Method</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" id="cod" value="cod" checked required>
                                <label class="form-check-label" for="cod">Cash on Delivery (COD)</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" id="online" value="online" required>
                                <label class="form-check-label" for="online">Razorpay (Cards, UPI, Netbanking)</label>
                            </div>
                            @error('payment_method') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                        <!-- Coupon Code -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Coupon Code (optional)</label>
                            <input type="text" name="coupon_code" class="form-control" placeholder="Enter coupon code">
                            @error('coupon_code') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-uppercase small">Total</span>
                            <span class="h4 serif text-dark cart-total">₹{{ number_format($total, 2) }}</span>
                        </div>

                        <button type="submit" class="btn btn-luxury py-3" id="placeOrderBtn">PLACE ORDER</button>
                    </form>
                    <p class="text-muted small text-center mt-3 mb-0">
                        Your order will be confirmed by our team.
                    </p>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-5">
            <i class="fas fa-shopping-bag fa-3x text-muted mb-3"></i>
            <p class="serif h4 opacity-50">Your bag is empty.</p>
            <a href="{{ route('home') }}" class="btn btn-luxury mt-3 px-5">Discover Cakes</a>
        </div>
    @endif
</div>

<!-- Razorpay Checkout Script -->
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

{{-- FETCH-BASED CART UPDATES – NO PAGE RELOAD --}}
<script type="text/javascript">
    (function() {
        // Helper to get CSRF token from meta tag
        function getCsrfToken() {
            return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        }

        // Helper to get the correct product ID from the row
        function getProductId(row) {
            // Use data-item-id if available, otherwise data-id
            return row.dataset.itemId || row.dataset.id;
        }

        // Update row subtotal and cart total after any change
        function updateRowSubtotal(row) {
            // Get price from the small element with class 'text-muted'
            const priceElement = row.querySelector('.text-muted'); // because <small class="text-muted"> contains the price
            const priceText = priceElement.innerText; // e.g., "₹499.00 / kg"
            const price = parseFloat(priceText.replace(/[^\d.]/g, '')); // extracts 499.00

            const weight = parseFloat(row.querySelector('.weight-select').value);
            const quantity = parseInt(row.querySelector('.quantity').value);

            const subtotal = price * weight * quantity;
            row.querySelector('.item-subtotal').innerText = '₹' + subtotal.toFixed(2);
            return subtotal;
        }

        function updateCartTotal() {
            let total = 0;
            document.querySelectorAll('.item-subtotal').forEach(el => {
                total += parseFloat(el.innerText.replace(/[^\d.]/g, ''));
            });
            const totalEl = document.querySelector('.cart-total');
            if (totalEl) {
                totalEl.innerText = '₹' + total.toFixed(2);
            }
        }

        // Quantity plus
        document.querySelectorAll('.update-cart-plus').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const row = this.closest('tr');
                const productId = getProductId(row);
                const quantityInput = row.querySelector('.quantity');
                let newQuantity = parseInt(quantityInput.value) + 1;

                fetch('{{ route("update.cart") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': getCsrfToken()
                    },
                    body: JSON.stringify({
                        id: productId,
                        quantity: newQuantity
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        quantityInput.value = newQuantity;
                        updateRowSubtotal(row);
                        updateCartTotal();
                    } else {
                        alert('Error updating cart');
                    }
                })
                .catch(() => alert('Network error'));
            });
        });

        // Quantity minus
        document.querySelectorAll('.update-cart-minus').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const row = this.closest('tr');
                const productId = getProductId(row);
                const quantityInput = row.querySelector('.quantity');
                let newQuantity = parseInt(quantityInput.value) - 1;
                if (newQuantity < 1) return; // Don't go below 1

                fetch('{{ route("update.cart") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': getCsrfToken()
                    },
                    body: JSON.stringify({
                        id: productId,
                        quantity: newQuantity
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        quantityInput.value = newQuantity;
                        updateRowSubtotal(row);
                        updateCartTotal();
                    } else {
                        alert('Error updating cart');
                    }
                })
                .catch(() => alert('Network error'));
            });
        });

        // Weight change
        document.querySelectorAll('.weight-select').forEach(select => {
            select.addEventListener('change', function() {
                const row = this.closest('tr');
                const productId = getProductId(row);
                const newWeight = this.value;

                fetch('{{ route("update.cart.weight") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': getCsrfToken()
                    },
                    body: JSON.stringify({
                        id: productId,
                        weight: newWeight
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        updateRowSubtotal(row);
                        updateCartTotal();
                    } else {
                        alert('Error updating weight');
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    alert('Network error – check console');
                });
            });
        });

        // Remove item – FIXED to use getProductId()
        document.querySelectorAll('.remove-from-cart').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                if (!confirm('Do you really want to remove this piece?')) return;

                const row = this.closest('tr');
                const productId = getProductId(row); // ← CORRECTED: uses data-item-id if available

                fetch(`{{ url('/remove-from-cart') }}/${productId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': getCsrfToken()
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        row.remove(); // Remove the row from DOM
                        updateCartTotal();
                        // If no rows left, reload to show empty cart message (or you can dynamically show it)
                        if (document.querySelectorAll('#cart-items-body tr').length === 0) {
                            location.reload(); // Simple way to show empty cart
                        }
                    } else {
                        alert('Error removing item');
                    }
                })
                .catch(() => alert('Network error'));
            });
        });
    })();

    // Razorpay jQuery code (unchanged)
    $(document).ready(function() {
        $('#checkoutForm').on('submit', function(e) {
            e.preventDefault();

            var paymentMethod = $('input[name="payment_method"]:checked').val();
            if (paymentMethod === 'cod') {
                // Normal submission for COD
                this.submit();
                return;
            }

            // For online payment, get Razorpay order via AJAX
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        var options = {
                            key: response.razorpay_key,
                            amount: response.amount,
                            currency: response.currency,
                            name: "Blonde Bakery",
                            description: "Order Payment",
                            order_id: response.order_id,
                            method: {
                                emi: false,
                                wallet: false,
                                paylater: false
                            },
                            prefill: {
                                name: response.name,
                                email: response.email,
                                contact: response.phone
                            },
                            handler: function(paymentResponse) {
                                // Verify payment on server
                                $.ajax({
                                    url: '{{ route('payment.verify') }}',
                                    method: 'POST',
                                    data: {
                                        _token: '{{ csrf_token() }}',
                                        razorpay_payment_id: paymentResponse.razorpay_payment_id,
                                        razorpay_order_id: paymentResponse.razorpay_order_id,
                                        razorpay_signature: paymentResponse.razorpay_signature
                                    },
                                    success: function(verifyResponse) {
                                        // Redirect to success page
                                        window.location.href = verifyResponse.redirect_url;
                                    },
                                    error: function() {
                                        alert('Payment verification failed. Please contact support.');
                                    }
                                });
                            },
                            modal: {
                                ondismiss: function() {
                                    alert('Payment cancelled');
                                }
                            }
                        };
                        var rzp = new Razorpay(options);
                        rzp.open();
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function(xhr) {
                    alert('Error processing payment. Please try again.');
                }
            });
        });
    });
</script>

{{-- Font Awesome --}}
<script src="https://kit.fontawesome.com/yourkitid.js" crossorigin="anonymous"></script>
<!-- If you don't have Font Awesome kit, include via CDN: -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>

</body>
</html>