@extends('layouts.app')

@section('title', 'Forbidden')

@section('content')
<div class="container text-center py-5">
    <div class="py-5">
        <i class="fas fa-lock fa-4x text-danger mb-4"></i>
        <h1 class="display-1 serif">403</h1>
        <h2 class="serif">Access Denied</h2>
        <p class="lead">You don't have permission to access this page.</p>
        <a href="{{ route('home') }}" class="btn btn-luxury mt-4">Back to Homepage</a>
    </div>
</div>
@endsection