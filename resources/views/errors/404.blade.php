@extends('layouts.app')

@section('title', 'Page Not Found')

@section('content')
<div class="container text-center py-5">
    <div class="py-5">
        <i class="fas fa-map-signs fa-4x text-gold mb-4"></i>
        <h1 class="display-1 serif">404</h1>
        <h2 class="serif">Oops! Page not found.</h2>
        <p class="lead">The page you're looking for doesn't exist or has been moved.</p>
        <a href="{{ route('home') }}" class="btn btn-luxury mt-4">Back to Homepage</a>
    </div>
</div>
@endsection