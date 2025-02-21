function initializeImageEditor(imageUrl) {
    var canvas = document.getElementById('imageCanvas');
    var ctx = canvas.getContext('2d');
    var img = new Image();
    img.src = imageUrl;
    var imgX = 50, imgY = 50;
    var imgWidth = 200, imgHeight = 200;
    var isDrawingMode = false;
    var lastX, lastY;

    // Draw the image when it's loaded
    img.onload = function() {
        canvas.width = 800;
        canvas.height = 600;
        ctx.drawImage(img, imgX, imgY, imgWidth, imgHeight);
    };

    // Event Listeners for the buttons
    document.getElementById('rotate').addEventListener('click', rotateImage);
    document.getElementById('flipHorizontal').addEventListener('click', flipHorizontal);
    document.getElementById('flipVertical').addEventListener('click', flipVertical);
    document.getElementById('addText').addEventListener('click', addText);
    document.getElementById('drawMode').addEventListener('click', toggleDrawMode);
    document.getElementById('download').addEventListener('click', downloadImage);
    document.getElementById('save').addEventListener('click', saveEditedImage);  // New Save Button

    // Rotate Image by 90 degrees
    function rotateImage() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.save();
        ctx.translate(imgX + imgWidth / 2, imgY + imgHeight / 2);
        ctx.rotate(90 * Math.PI / 180);
        ctx.drawImage(img, -imgWidth / 2, -imgHeight / 2, imgWidth, imgHeight);
        ctx.restore();
    }

    // Flip Image horizontally
    function flipHorizontal() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.save();
        ctx.translate(imgX + imgWidth, imgY);
        ctx.scale(-1, 1);
        ctx.drawImage(img, 0, 0, imgWidth, imgHeight);
        ctx.restore();
    }

    // Flip Image vertically
    function flipVertical() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.save();
        ctx.translate(imgX, imgY + imgHeight);
        ctx.scale(1, -1);
        ctx.drawImage(img, 0, 0, imgWidth, imgHeight);
        ctx.restore();
    }

    // Add text to image
    function addText() {
        ctx.font = '30px Arial';
        ctx.fillStyle = 'red';
        ctx.fillText('Hello, World!', 100, 100);
    }

    // Toggle draw mode
    function toggleDrawMode() {
        isDrawingMode = !isDrawingMode;
        if (isDrawingMode) {
            canvas.onmousedown = function(e) {
                lastX = e.offsetX;
                lastY = e.offsetY;
                canvas.onmousemove = function(e) {
                    if (!isDrawingMode) return;
                    ctx.beginPath();
                    ctx.moveTo(lastX, lastY);
                    ctx.lineTo(e.offsetX, e.offsetY);
                    ctx.strokeStyle = 'blue';
                    ctx.lineWidth = 5;
                    ctx.stroke();
                    lastX = e.offsetX;
                    lastY = e.offsetY;
                };
            };
            canvas.onmouseup = function() {
                canvas.onmousemove = null;
            };
        } else {
            canvas.onmousedown = null;
            canvas.onmousemove = null;
        }
    }

    // Download the image
    function downloadImage() {
        var dataUrl = canvas.toDataURL();
        document.getElementById('download').setAttribute('href', dataUrl);
    }

    // Save the edited image to the server using AJAX
    function saveEditedImage() {
        var imageData = canvas.toDataURL(); // Get the base64 data of the canvas
        $.ajax({
            url: '/save-edited-image', // Route to save the image
            type: 'POST',
            data: {
                _token: "{{ csrf_token() }}", // CSRF token for security
                imageData: imageData
            },
            success: function(response) {
                if (response.success) {
                    alert("Image saved successfully!");
                    // Provide the user with the URL to download the saved image
                    $('#download').attr('href', response.imageUrl).text('Download Edited Image');
                } else {
                    alert("Failed to save the image.");
                }
            },
            error: function() {
                alert("An error occurred while saving the image.");
            }
        });
    }
}
