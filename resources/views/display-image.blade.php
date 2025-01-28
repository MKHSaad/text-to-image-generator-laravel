@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="text-center">Generated Image</h2>
    <div class="text-center">
        @if(isset($imageUrl))
        <img src="{{ $imageUrl }}" alt="Generated Image" style="max-width: 100%; height: auto;">
        @else
        <p>No image available</p>
        @endif
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

@endsection