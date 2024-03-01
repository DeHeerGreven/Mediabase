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
                <img src="{{ asset($imagePath) }}" id="imagePreview" alt="Uploaded Image" class="max-w-full h-auto">
            </div>
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
    </script>
@endpush
