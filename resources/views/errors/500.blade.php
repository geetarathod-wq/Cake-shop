@extends('layouts.app')

@section('title', 'Server Error')

@section('content')
<div class="container text-center py-5">
    <div class="py-5">
        <i class="fas fa-exclamation-triangle fa-4x text-warning mb-4"></i>
        <h1 class="display-1 serif">500</h1>
        <h2 class="serif">Something went wrong</h2>
        <p class="lead">Our team has been notified. Please try again later.</p>
        <a href="{{ route('home') }}" class="btn btn-luxury mt-4">Back to Homepage</a>
    </div>
</div>
@endsection