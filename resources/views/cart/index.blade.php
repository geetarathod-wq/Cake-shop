<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Atelier Bag | Blonde Bakery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('Fevicon_Cake.png') }}">
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
        .checkout-form { background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.03); }
        .form-control:focus { border-color: var(--gold); box-shadow: 0 0 0 0.2rem rgba(212,175,55,0.1); }
    </style>
</head>
<body>

<div class="container py-5">
    <h1 class="serif display-5 text-center mb-5">Your Selection</h1>

    @php
        $cart = session('cart', []);
        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
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
                                <th>Quantity</th>
                                <th>Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cart as $id => $details)
                                <tr data-id="{{ $id }}">
                                    <td style="width: 100px;">
                                        @if(!empty($details['image']) && file_exists(public_path('storage/'.$details['image'])))
                                            <img src="{{ asset('storage/'.$details['image']) }}" class="cart-item-img" alt="{{ $details['name'] }}">
                                        @else
                                            <div style="width: 80px; height: 80px; background: #f8f8f8; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-cake-candles fs-3 text-muted"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <h6 class="mb-0 fw-bold">{{ $details['name'] }}</h6>
                                        <small class="text-muted">₹{{ number_format($details['price'], 2) }} / kg</small>
                                        @if(isset($details['weight']))
                                            <span class="badge bg-light text-dark ms-2">{{ $details['weight'] }} kg</span>
                                        @endif
                                    </td>
                                    <td style="width: 120px;">
                                        <div class="d-flex align-items-center border p-1" style="width: fit-content; background: white;">
                                            <span class="qty-btn px-2 update-cart-minus"><i class="fa fa-minus small"></i></span>
                                            <input type="number" value="{{ $details['quantity'] }}" class="qty-input quantity" readonly>
                                            <span class="qty-btn px-2 update-cart-plus"><i class="fa fa-plus small"></i></span>
                                        </div>
                                    </td>
                                    <td class="serif fw-bold">₹{{ number_format($details['price'] * $details['quantity'], 2) }}</td>
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
                        <form action="{{ route('checkout.store') }}" method="POST">
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
                                <button type="submit" class="btn btn-luxury w-100 py-3">PLACE ORDER</button>
                            </div>
                        </div>
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

<script type="text/javascript">
    $(".update-cart-plus").click(function (e) {
        e.preventDefault();
        var ele = $(this);
        var qtyField = ele.closest("tr").find(".quantity");
        var newQty = parseInt(qtyField.val()) + 1;
        updateCart(ele.closest("tr").attr("data-id"), newQty);
    });

    $(".update-cart-minus").click(function (e) {
        e.preventDefault();
        var ele = $(this);
        var qtyField = ele.closest("tr").find(".quantity");
        var newQty = parseInt(qtyField.val()) - 1;
        if(newQty > 0) {
            updateCart(ele.closest("tr").attr("data-id"), newQty);
        }
    });

    $(".remove-from-cart").click(function (e) {
        e.preventDefault();
        var ele = $(this);
        var cartKey = ele.closest("tr").attr("data-id");
        if(confirm("Do you really want to remove this piece?")) {
            $.ajax({
                url: "{{ url(path: '/remove-from-cart') }}/" + cartKey,                method: "DELETE",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function (response) {
                    window.location.reload();
                },
                error: function(xhr) {
                    alert('Error removing item. Please try again.');
                }
            });
        }
    });

    function updateCart(id, qty) {
        $.ajax({
            url: '{{ route('update.cart') }}',
            method: "POST",
            data: {
                _token: '{{ csrf_token() }}',
                id: id,
                quantity: qty
            },
            success: function (response) {
                window.location.reload();
            },
            error: function(xhr) {
                alert('Error updating quantity. Please try again.');
            }
        });
    }
</script>

</body>
</html>