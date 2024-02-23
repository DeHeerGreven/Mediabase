<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Xbox-like Image Cropper</title>
    <script src="https://cdn.jsdelivr.net/npm/cropperjs"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js" integrity="sha512-9KkIqdfN7ipEW6B6k+Aq20PV31bjODg4AA52W+tYtAE0jE0kMx49bjJ3FgvS56wzmyfMUHbQ4Km2b7l9+Y/+Eg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.css" integrity="sha512-bs9fAcCAeaDfA4A+NiShWR886eClUcBtqhipoY5DM60Y1V3BbVQlabthUBal5bq8Z8nnxxiyb1wfGX2n76N1Mw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-white py-12">
    <div class="container mx-auto px-4">
        <form method="POST" action="{{ route('projects.update-image', $project) }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
        
            <!-- Hidden input to store the original image path -->
            <input type="hidden" name="original_image_path" value="{{ asset($photo->image_path) }}">
        
            <!-- Display the image from the project -->
            <div class="max-w-md mx-auto mb-8">
                <img class="block w-full rounded-lg shadow-md" src="{{ asset($photo->image_path) }}" id="cropper-image" alt="Image to crop">
            </div>
        
            <!-- Provide options for editing -->
        
            <button type="submit" class="block mx-auto bg-green-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-green-600">Save</button>
        </form>
        
        <div class="max-w-md mx-auto mb-8">
            <label class="block mb-2 text-gray-400">Zoom:</label>
            <input type="range" id="zoom" value="1" min="0.1" max="3" step="0.1" class="w-full">
        </div>
        
        <div class="max-w-md mx-auto mb-8">
            <button id="rotate-left" class="bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg mr-2 hover:bg-blue-600">Rotate Left</button>
            <button id="rotate-right" class="bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-600">Rotate Right</button>
        </div>
    </div>
    
    <script>
        const image = document.getElementById('cropper-image');
        const cropper = new Cropper(image, {
            aspectRatio: 1 / 1,
            crop(event) {
            console.log(event.detail.x);
            console.log(event.detail.y);
            console.log(event.detail.width);
            console.log(event.detail.height);
            console.log(event.detail.rotate);
            console.log(event.detail.scaleX);
            console.log(event.detail.scaleY);
            },
            zoomable: true,
            rotatable: true,
            scalable: true,
            zoomOnTouch: true,
            zoomOnWheel: true
        });
    
        const zoomInput = document.getElementById('zoom');
        zoomInput.addEventListener('input', function () {
            cropper.zoomTo(this.value);
        });
    
        document.getElementById('rotate-left').addEventListener('click', function () {
            cropper.rotate(-90);
        });
    
        document.getElementById('rotate-right').addEventListener('click', function () {
            cropper.rotate(90);
        });
    
        // Function to crop the image and get the cropped data
        function cropImage() {
            // Get the cropped data
            const croppedData = cropper.getCroppedCanvas().toDataURL();
    
            // Set the cropped data as the src of the image
            image.src = croppedData;
        }
    
        // Add event listener to the save button to crop the image before submitting the form
        document.querySelector('form').addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent the default form submission
    
            // Crop the image
            cropImage();
    
            // Submit the form
            this.submit();
        });
    </script>
</body>
</html>
