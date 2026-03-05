<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Shopping Bag | Blonde Bakery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Montserrat:wght@300;400;600&display=swap');
        
        :root {
            --cream: #FFFDF5;
            --gold: #C5A059;
            --dark: #2C1810;
        }

        body {
            background-color: var(--cream);
            font-family: 'Montserrat', sans-serif;
            color: var(--dark);
        }

        .serif { font-family: 'Playfair Display', serif; }

        .cart-container {
            max-width: 900px;
            margin: 80px auto;
            background: white;
            padding: 40px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.05);
            border-radius: 15px;
        }

        .cart-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            margin-right: 15px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            background-color: #f8f8f8;
        }

        .btn-luxury {
            background: var(--dark);
            color: white;
            border-radius: 0;
            padding: 12px 30px;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 0.8rem;
            transition: 0.3s;
            border: 1px solid var(--dark);
            text-decoration: none;
            display: inline-block;
        }

        .btn-luxury:hover {
            background: transparent;
            color: var(--dark);
        }

        .text-gold { color: var(--gold); }
        .letter-spacing-2 { letter-spacing: 2px; }
    </style>
</head>
<body>

<div class="container">
    <div class="cart-container">
        <div class="text-center mb-5">
            <h1 class="serif display-5">Your Shopping Bag</h1>
            <a href="{{ route('home') }}" class="text-gold text-decoration-none small letter-spacing-2 text-uppercase">
                <i class="fa-solid fa-arrow-left me-2"></i> Continue Shopping
            </a>
        </div>

        @php $total = 0 @endphp
        @if(session('cart') && count(session('cart')) > 0)
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr class="text-uppercase small letter-spacing-1 text-muted">
                            <th>Product</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(session('cart') as $id => $details)
                            @php 
                                $itemWeight = $details['weight'] ?? 1; 
                                $basePrice = $details['price'];
                                // Logic: 0.5kg is 60% of the 1kg price
                                $displayPrice = ($itemWeight == 0.5) ? ($basePrice * 0.6) : $basePrice;
                                $subtotal = $displayPrice * $details['quantity'];
                                $total += $subtotal;
                            @endphp
                            <tr class="cart-item">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('products/'.$details['image']) }}" 
                                             onerror="this.src='https://via.placeholder.com/80?text=Cake'" 
                                             class="cart-img">
                                        <div>
                                            <span class="fw-bold d-block">{{ $details['name'] }}</span>
                                            <small class="text-muted text-uppercase">{{ $itemWeight }} KG</small>
                                        </div>
                                    </div>
                                </td>
                                <td>${{ number_format($displayPrice, 2) }}</td>
                                <td>{{ $details['quantity'] }}</td>
                                <td class="fw-bold text-dark">${{ number_format($subtotal, 2) }}</td>
                                <td>
                                    {{-- Use the key from the loop ($id) which acts as the cartKey --}}
                                    <form action="{{ route('cart.remove', $id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn text-danger btn-sm">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="row mt-5 justify-content-end text-end">
                <div class="col-md-4">
                    <h5 class="serif">Total: <span class="text-gold">${{ number_format($total, 2) }}</span></h5>
                    <p class="text-muted small">Shipping and taxes calculated at checkout.</p>
                    
                    {{-- Updated button to prevent 500 error --}}
                    <button type="button" class="btn btn-luxury w-100 mt-3" onclick="alert('Checkout coming soon!')">
                        Place Order
                    </button>
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fa-solid fa-bag-shopping fa-3x mb-3 text-muted"></i>
                <p>Your bag is currently empty.</p>
                <a href="{{ route('home') }}" class="btn btn-luxury mt-3">Back to Collection</a>
            </div>
        @endif
    </div>
</div>

</body>
</html>