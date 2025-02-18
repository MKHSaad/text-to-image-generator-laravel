@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="text-center">Generated Image Editor</h2>
    <div class="text-center">
        
        @if(isset($imageUrl))
            <!-- Image Display -->
            <canvas id="imageCanvas" style="border: 1px solid #ccc; max-width: 100%; height: auto;"></canvas>
            
            <!-- Action Buttons -->
            <div class="mt-4">
                <!-- Download Button -->
                <a id="download" href="#" download class="btn btn-primary">Download Edited Image</a>
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

<!-- Include jQuery, Bootstrap, and Fabric.js -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.2.0/fabric.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize Fabric.js Canvas
        var canvas = new fabric.Canvas('imageCanvas', {
            width: 800,
            height: 600,
            backgroundColor: '#f3f3f3',
            selection: true,
        });

        var imageUrl = "{{ $imageUrl }}"; // Image URL passed from backend
        var imgElement = new Image();
        imgElement.src = imageUrl;

        imgElement.onload = function() {
            var img = new fabric.Image(imgElement, {
                left: 50,
                top: 50,
                scaleX: 0.5, // Default scale
                scaleY: 0.5, // Default scale
            });
            canvas.add(img);
            canvas.setActiveObject(img);
        };

        // Rotate Image 90 degrees
        $('#rotate').click(function() {
            var obj = canvas.getActiveObject();
            if (obj) {
                obj.rotate(obj.angle + 90);
                canvas.renderAll();
            }
        });

        // Flip Image horizontally
        $('#flipHorizontal').click(function() {
            var obj = canvas.getActiveObject();
            if (obj) {
                obj.set('flipX', !obj.flipX);
                canvas.renderAll();
            }
        });

        // Flip Image vertically
        $('#flipVertical').click(function() {
            var obj = canvas.getActiveObject();
            if (obj) {
                obj.set('flipY', !obj.flipY);
                canvas.renderAll();
            }
        });

        // Add Text to Image
        $('#addText').click(function() {
            var text = new fabric.Text('Hello, World!', {
                left: 100,
                top: 100,
                fontFamily: 'Arial',
                fontSize: 30,
                fill: 'red',
            });
            canvas.add(text);
        });

        // Toggle Draw Mode
        var isDrawingMode = false;
        $('#drawMode').click(function() {
            isDrawingMode = !isDrawingMode;
            canvas.isDrawingMode = isDrawingMode;
            if (isDrawingMode) {
                canvas.freeDrawingBrush.color = 'blue';
                canvas.freeDrawingBrush.width = 5;
            }
        });

        // Download Edited Image
        $('#download').click(function() {
            var dataUrl = canvas.toDataURL({
                format: 'png',
            });
            $('#download').attr('href', dataUrl);
        });
    });
</script>
@endsection