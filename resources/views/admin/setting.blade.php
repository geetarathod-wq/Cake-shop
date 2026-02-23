<!-- @extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h2 class="fw-bold">Admin Settings</h2>
        <p class="text-muted">Manage your boutique profile and security credentials.</p>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm p-4 h-100">
                <div class="d-flex align-items-center mb-4">
                    <div class="bg-light-pink p-3 rounded-circle me-3">
                        <i class="fas fa-store text-danger fs-4"></i>
                    </div>
                    <h5 class="fw-bold m-0">Shop Information</h5>
                </div>
                
                <form>
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">SHOP NAME</label>
                        <input type="text" class="form-control" value="MyCakes Boutique" placeholder="Enter shop name">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">CONTACT EMAIL</label>
                        <input type="email" class="form-control" value="admin@mycakes.com" placeholder="admin@example.com">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">CONTACT NUMBER</label>
                        <input type="text" class="form-control" value="+91 9876543210">
                    </div>
                    <button type="button" class="btn btn-primary px-4 mt-2">Update Profile</button>
                </form>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm p-4 h-100">
                <div class="d-flex align-items-center mb-4">
                    <div class="bg-light-info p-3 rounded-circle me-3">
                        <i class="fas fa-lock text-info fs-4"></i>
                    </div>
                    <h5 class="fw-bold m-0">Security & Password</h5>
                </div>

                <form>
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">CURRENT PASSWORD</label>
                        <input type="password" class="form-control" placeholder="••••••••">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">NEW PASSWORD</label>
                        <input type="password" class="form-control" placeholder="Minimum 8 characters">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">CONFIRM NEW PASSWORD</label>
                        <input type="password" class="form-control" placeholder="••••••••">
                    </div>
                    <button type="button" class="btn btn-outline-info px-4 mt-2">Change Password</button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-light-pink { background-color: #fce4ec; }
    .bg-light-info { background-color: #e0f7fa; }
    .form-control:focus {
        border-color: #e91e63;
        box-shadow: 0 0 0 0.25 cold-rgba(233, 30, 99, 0.1);
    }
</style>
@endsection -->
@extends('layout')
@section('content')
    <div class="container">
        <h2>Admin Settings</h2>
        <p>Update your bakery details here.</p>
    </div>
@endsection