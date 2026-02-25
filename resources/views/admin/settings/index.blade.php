@extends('admin.layouts.app')

@section('title', 'Settings - Blonde Bakery Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0 fw-bold">Settings</h1>
        <p class="text-muted">Manage your bakery settings</p>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('admin.settings.update') }}" method="POST">
                    @csrf

                    <h5 class="serif fw-bold mb-3">Site Information</h5>
                    <div class="mb-3">
                        <label class="form-label">Site Name</label>
                        <input type="text" name="site_name" class="form-control @error('site_name') is-invalid @enderror" value="{{ old('site_name', $settings['site_name']) }}" required>
                        @error('site_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Contact Email</label>
                        <input type="email" name="contact_email" class="form-control @error('contact_email') is-invalid @enderror" value="{{ old('contact_email', $settings['contact_email']) }}" required>
                        @error('contact_email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Contact Phone</label>
                        <input type="text" name="contact_phone" class="form-control @error('contact_phone') is-invalid @enderror" value="{{ old('contact_phone', $settings['contact_phone']) }}" required>
                        @error('contact_phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="2" required>{{ old('address', $settings['address']) }}</textarea>
                        @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <hr class="my-4">

                    <h5 class="serif fw-bold mb-3">Delivery Settings</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Delivery Fee (₹)</label>
                            <input type="number" step="0.01" name="delivery_fee" class="form-control @error('delivery_fee') is-invalid @enderror" value="{{ old('delivery_fee', $settings['delivery_fee']) }}" required>
                            @error('delivery_fee') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Free Delivery Threshold (₹)</label>
                            <input type="number" step="0.01" name="free_delivery_threshold" class="form-control @error('free_delivery_threshold') is-invalid @enderror" value="{{ old('free_delivery_threshold', $settings['free_delivery_threshold']) }}" required>
                            @error('free_delivery_threshold') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-gold px-5">
                            <i class="fas fa-save me-2"></i>Save Settings
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="bg-light p-4 rounded-3">
            <h5 class="serif fw-bold mb-3">How to Use</h5>
            <p class="small text-muted mb-2">
                <i class="fas fa-circle-info me-2 text-gold"></i>
                These settings are used across the site:
            </p>
            <ul class="small text-muted ps-3">
                <li><strong>Site Name</strong> – appears in the browser title and footer.</li>
                <li><strong>Contact details</strong> – shown in the footer and contact page.</li>
                <li><strong>Delivery settings</strong> – used during checkout to calculate charges.</li>
            </ul>
            <hr>
            <p class="small text-muted mb-0">
                After saving, changes take effect immediately.
            </p>
        </div>
    </div>
</div>
@endsection