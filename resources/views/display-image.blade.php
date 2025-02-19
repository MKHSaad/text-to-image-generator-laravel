@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h2 class="text-center">Generated Image Editor</h2>
        <div class="text-center">

            @if(isset($imageUrl))
                <!-- Canvas for Drawing and Image Manipulation -->
                <canvas id="imageCanvas" style="border: 1px solid #ccc; max-width: 100%; height: auto;"></canvas>

                <!-- Action Buttons -->
                <div class="mt-4">
                    <!-- Download Button -->
                    <a id="download" href="#" download class="btn btn-primary">Download Edited Image</a>
                    <!-- Save Button (to save edited image) -->
                    <button id="save" class="btn btn-success">Save Edited Image</button>
                    <!-- Modify Options -->
                    <button id="rotate" class="btn btn-warning">Rotate</button>
                    <button id="flipHorizontal" class="btn btn-info">Flip Horizontal</button>
                    <button id="flipVertical" class="btn btn-info">Flip Vertical</button>
                    <button id="addText" class="btn btn-success">Add Text</button>
                    <button id="drawMode" class="btn btn-secondary">Draw Mode</button>
                </div>
            @else
                <p>No image available</p>
            @endif
        </div>
    </div>

    <!-- Include jQuery and Bootstrap for UI -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Link to the external JS file -->
    <script src="{{ asset('js/image-editor.js') }}"></script>

    <script>
        $(document).ready(function () {
            // Initialize the image editor with the image URL
            const imageUrl = "{{ $imageUrl }}";
            initializeImageEditor(imageUrl);
        });
    </script>
@endsection