@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-8">
        <div class="bg-gray-800 text-white p-6 rounded-lg shadow-lg">
            <h2 class="text-3xl font-semibold mb-4">Edit Photo</h2>
            <form action="{{ route('projects.save-photo', $project) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="image" class="block mb-2">Upload Image:</label>
                    <input type="file" name="image" id="image" accept="image/*" class="border rounded p-2 w-full bg-gray-700 text-white">
                </div>
                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">Save</button>
            </form>
        </div>

        <div class="mt-8">
            <h3 class="text-xl font-semibold mb-4">Preview:</h3>
            <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
                @if ($photo)
                    <img src="{{ asset($photo->image_path) }}" id="imagePreview" alt="Uploaded Image" class="max-w-full h-auto">
                @else
                    <div class="text-gray-400">No image uploaded</div>
                @endif
            </div>
            <button id="saveImageBtn" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Save Edited Image</button>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const image = document.getElementById('image');
            const imagePreview = document.getElementById('imagePreview');
            const cropper = new Cropper(imagePreview, {
                aspectRatio: 16 / 9,
                crop(event) {
                    console.log(event.detail.x);
                    console.log(event.detail.y);
                    console.log(event.detail.width);
                    console.log(event.detail.height);
                },
            });

            image.addEventListener('change', (e) => {
                const file = e.target.files[0];
                const reader = new FileReader();

                reader.onload = () => {
                    imagePreview.src = reader.result;
                    cropper.replace(reader.result);
                };

                reader.readAsDataURL(file);
            });
        });
        const saveImageBtn = document.getElementById('saveImageBtn');
        saveImageBtn.addEventListener('click', () => {
            // Get the cropped image data
            const croppedImageData = cropper.getCroppedCanvas().toDataURL('image/jpeg');

            // Send the cropped image data to the backend
            fetch('{{ route("projects.save-edited-photo", $project) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ image: croppedImageData })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to save edited image');
                }
                return response.json();
            })
            .then(data => {
                // Handle success
                console.log('Edited image saved successfully:', data);
            })
            .catch(error => {
                // Handle error
                console.error('Error saving edited image:', error);
            });
        });
    </script>
@endpush
