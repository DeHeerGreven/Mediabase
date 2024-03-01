@extends('layouts.app')

@section('content')
    <div class="container mt-8 flex flex-col items-center justify-center" style="height: 100vh;"> <!-- Center content vertically and horizontally -->
        <h1 class="text-black text-2xl mb-4">Foto uploaden</h1>
        <p class="mb-0">Klik hieronder om een foto te uploaden of sleep de foto naar het</p>
        <p class="mb-4">project</p>

        <!-- Form for uploading images -->
        <form id="uploadForm" action="/moodboard/upload" method="post" enctype="multipart/form-data" class="mb-8">
            @csrf
            <label for="image" class="upload-button inline-block">Uploaden</label>
            <input type="file" name="image" id="image" style="display: none;" onchange="uploadImage()">
        </form>

        <!-- Display moodboard photos inside a larger box -->
        <div id="moodboard-box" class="moodboard-box flex justify-center items-center" style="width: 80vw; border: 1px solid black;">

            @if($moodboard)
                @foreach($moodboard->moodboard_photos as $photo)
                    <img src="{{ asset($photo->image_path) }}" alt="Moodboard Photo" class="moodboard-photo-small" draggable="true">
                @endforeach
            @else
                <p>No moodboard found.</p>
            @endif
        </div>

        <!-- 6 small colored boxes -->
        <div class="flex justify-between mt-4" style="width: 80vw;">
            <div class="small-box" style="width: calc(16.666% - 10px); height: 50px; background-color: #FFC0CB;"></div>
            <div class="small-box" style="width: calc(16.666% - 10px); height: 50px; background-color: #ADD8E6;"></div>
            <div class="small-box" style="width: calc(16.666% - 10px); height: 50px; background-color: #90EE90;"></div>
            <div class="small-box" style="width: calc(16.666% - 10px); height: 50px; background-color: #FFD700;"></div>
            <div class="small-box" style="width: calc(16.666% - 10px); height: 50px; background-color: #D3D3D3;"></div>
            <div class="small-box" style="width: calc(16.666% - 10px); height: 50px; background-color: #FFA07A;"></div>
        </div>

        <!-- Hex code input -->
        <div class="mt-4">
            <label for="hex">Hex Code:</label>
            <input type="range" id="hex" name="hex" min="0" max="360" value="0">
        </div>
    </div>

    <!-- Sliders for hue, saturation, and brightness -->
    <div class="container mt-4 flex flex-col items-center justify-center" style="width: 80vw;"> <!-- Center content vertically and horizontally -->
        <div class="mt-4">
            <label for="hue">Hue:</label>
            <input type="range" id="hue" name="hue" min="0" max="360" value="0">
        </div>
        <div class="mt-4">
            <label for="saturation">Saturation:</label>
            <input type="range" id="saturation" name="saturation" min="0" max="100" value="50">
        </div>
        <div class="mt-4">
            <label for="brightness">Brightness:</label>
            <input type="range" id="brightness" name="brightness" min="0" max="100" value="50">
        </div>
    </div>

    <script>
        function uploadImage() {
            document.getElementById("uploadForm").submit();
        }   

        const moodboardBox = document.getElementById("moodboard-box");

        // Add event listeners for drag and drop
        moodboardBox.addEventListener("dragover", function(event) {
            event.preventDefault();
        });

        moodboardBox.addEventListener("drop", function(event) {
            event.preventDefault();
            const imageSrc = event.dataTransfer.getData("text/plain");
            const img = document.createElement("img");
            img.src = imageSrc;
            img.alt = "Moodboard Photo";
            img.classList.add("moodboard-photo-small");
            moodboardBox.appendChild(img);
            const originalImage = document.querySelector("[src='" + imageSrc + "']");
            originalImage.parentNode.removeChild(originalImage);
        });
    </script>
@endsection
