<section class="py-5" style="margin-top: 100px;">
    <div class="container">
        <div class="row">
            <div class="col-lg-7">
                <h2 class="serif h3 mb-4">Delivery Details</h2>
                <form action="{{ route('place.order') }}" method="POST" class="row g-3">
                    @csrf
                    <div class="col-md-6">
                        <label class="small text-uppercase letter-spacing-2">Full Name</label>
                        <input type="text" name="name" class="form-control border-dark rounded-0" required>
                    </div>
                    <div class="col-md-6">
                        <label class="small text-uppercase letter-spacing-2">Phone Number</label>
                        <input type="text" name="phone" class="form-control border-dark rounded-0" required>
                    </div>
                    <div class="col-12 mt-3">
                        <label class="small text-uppercase letter-spacing-2">Delivery Address</label>
                        <textarea name="address" rows="3" class="form-control border-dark rounded-0" required></textarea>
                    </div>
                    <button type="submit" class="btn-luxury mt-4">Confirm & Place Order</button>
                </form>
            </div>

            <div class="col-lg-4 offset-lg-1 bg-white p-4 shadow-sm h-100">
                <h4 class="serif mb-4">Order Summary</h4>
                @foreach((array) session('cart') as $id => $details)
                <div class="d-flex justify-content-between mb-2">
                    <span class="small">{{ $details['name'] }} x {{ $details['quantity'] }}</span>
                    <span class="small">₹{{ number_format($details['price'] * $details['quantity'], 2) }}</span>
                </div>
                @endforeach
                <hr>
                <div class="d-flex justify-content-between fw-bold">
                    <span>GRAND TOTAL</span>
                    <span class="text-gold">₹{{ number_format(collect(session('cart'))->sum(fn($item) => $item['price'] * $item['quantity']), 2) }}</span>
                </div>
            </div>
        </div>
    </div>
</section>