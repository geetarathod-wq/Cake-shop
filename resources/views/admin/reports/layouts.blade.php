@extends('admin.layouts.app')

@section('title', $title ?? 'Report')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">{{ $title }}</h2>
    </div>

    @if(isset($filters))
    <div class="card mb-4 p-3">
        {{ $filters }}
    </div>
    @endif

    <div class="table-container">
        {{ $slot }}
    </div>

</div>

@endsection