@extends('layouts.app')

@section('content')
  
     
<div class="container mt-8 flex flex-col items-center justify-center bg-gray-200" style="height: 60vh; width: 250vh"> <!-- Center content vertically and horizontally -->
    <!-- Move upload section to the left -->
    <div class="upload-section" style="width: 80vw;"> <!-- Move to the left -->
        <h1 class="text-black text-2x2 mb-4">Foto uploaden</h1>
        <p class="mb-0">Klik hieronder om een foto te uploaden of sleep de foto naar het</p>
        <p class="mb-4">project</p>




        <form id="uploadForm" action="/moodboard/upload" method="post" enctype="multipart/form-data" class="mb-8">
            @csrf
            <label for="image" class="upload-button inline-block">Uploaden</label>
          <input type="file" name="image[]" id="image" style="display: none;" onchange="uploadImage()" multiple>
        </form>
    </div>
</div>



        <div class="container mt-8 flex flex-col items-center justify-center" style="height: 100vh;"> 
        
        <div id="moodboard-box" class="moodboard-box flex justify-center items-center" style="width: 80vw; border: 1px solid black;">

            @if($moodboard)
                @foreach($moodboard->moodboard_photos as $photo)
                    <img src="{{ asset($photo->image_path) }}" alt="Moodboard Photo" class="moodboard-photo-small" draggable="true">
                @endforeach
            @else
                <p>No moodboard found.</p>
            @endif
        </div>

<div class="flex justify-between mt-4" style="width: 80vw;">
    @foreach($colorCards as $hex)
        <div class="small-box" id="box_{{ $loop->index }}" style="width: calc(16.666% - 10px); height: 50px; background-color: {{ $hex }}"></div>
    @endforeach
</div>  

        <!-- Hex code input -->
       
    </div>
    <div class="container mt-8 flex flex-col items-start justify-center" style="width: 35vw; margin-left: 9vw; margin-top: -vh; margin-bottom: 10vh">
        <form action="{{ route('moodboard.create', $project) }}" method="post">
            @csrf
            <h1>Moodboard Aanmaken</h1>
            <div class="mt-4 mb-3">
                <label for="name" class="form-label">Naam:</label>
                <input type="text" id="name" name="name" required class="form-control">
            </div>
            <div class="mt-4 mb-3">
                <label for="description" class="form-label">Omschrijving:</label>
                <textarea id="description" name="description" required class="form-control" style="width:100%;"></textarea>
            </div>
    
            <div class="mt-4 mb-3">
                <label for="hex" class="form-label">Hex Code:</label>
                <div class="input-group" style="width:100%;">
                    <input type="text" id="hex" name="hex" min="0" max="360" value="0" class="form-control">
                    <button type="button" onclick="changeColor()" class="btn btn-primary">Toepassen</button>
                </div>
            </div>

        
            <div class="mt-4 mb-3">
                <label for="hue" class="form-label">Hexdecimale Code:</label>
                <input type="range" id="hue" name="hue" min="0" max="100" value="0" class="form-range" style="width:100%;" readonly disabled>
            </div>
            <div class="mt-4 mb-3">
                <label for="saturation" class="form-label">Verzadiging:</label>
                <input type="range" id="saturation" name="saturation" min="0" max="100" value="0" class="form-range" style="width:1050px;" readonly disabled>
            </div>
            <div class="mt-4 mb-3">
                <label for="brightness" class="form-label">Helderheid:</label>
                <input type="range" id="brightness" name="brightness" min="0" max="100" value="0" class="form-range" style="width:100%;" readonly disabled>
            </div>
    
            <div class="mt-4 mb-3">
                <button type="submit" class="btn btn-primary">Moodboard Opslaan</button>
            </div>
        </form>
    </div>
    

    
    <script>

        function uploadImage() {
            document.getElementById("uploadForm").submit();
        }   

        const moodboardBox = document.getElementById("moodboard-box");

       
       // Prevent default behavior for dragover event
moodboardBox.addEventListener("dragover", function(event) {
    event.preventDefault();
});

// Handle drop event
moodboardBox.addEventListener("drop", function(event) {
    event.preventDefault();
    // Get the image file from data transfer
    const file = event.dataTransfer.files[0];
    // Check if the dropped item is an image
    if (file && file.type.startsWith('image/')) {
        // Create a FileReader object to read the dropped file
        const reader = new FileReader();
        reader.onload = function(event) {
            // Create an img element to display the dropped image
            const img = document.createElement("img");
            img.src = event.target.result;
            img.alt = "Moodboard Photo";
            img.classList.add("moodboard-photo-small");
            moodboardBox.appendChild(img);
        };
        // Read the dropped file as Data URL
        reader.readAsDataURL(file);
    }
});


        // Function to change color of clicked small box
        function changeBoxColor(boxId) {
            const hexCode = document.getElementById('hex').value;
            const saturation = document.getElementById('saturation').value;
            const brightness = document.getElementById('brightness').value;
            const box = document.getElementById(boxId);
            box.style.backgroundColor = hexCode;
            updateHSBValues(hexCode);
        }
    
        // Add event listeners to small boxes
        const smallBoxes = document.querySelectorAll('.small-box');
        smallBoxes.forEach(box => {
            box.addEventListener('click', function() {
                changeBoxColor(box.id);
            });
        });
    
        // Function to update HSB sliders based on hex color
        function updateHSBValues(hexCode) {
            const hslColor = hexToHSL(hexCode);
            const hue = hslColor[0];
            const saturation = hslColor[1] * 100;
            const brightness = hslColor[2] * 100;
            document.getElementById('hue').value = hue;
            document.getElementById('saturation').value = saturation;
            document.getElementById('brightness').value = brightness;
        }
    
        // Function to change color using hex code
        function changeColor() {
            const hexCode = document.getElementById('hex').value;
            // Set the color of the clicked box (if any)
            const clickedBox = document.querySelector('.small-box.clicked');
            if (clickedBox) {
                clickedBox.style.backgroundColor = hexCode;
                updateHSBValues(hexCode);
            }
        }
    
        // Function to update color when sliders are changed
   // Function to update color when sliders are changed
// Function to update color when sliders are changed
function updateColor() {
    const hue = parseFloat(document.getElementById('hue').value);
    const saturation = parseFloat(document.getElementById('saturation').value);
    const brightness = parseFloat(document.getElementById('brightness').value);
    const hexCode = hslToHex(hue, saturation, brightness);
    document.getElementById('hex').value = hexCode; // Set the hex code value
    changeColor(); // Call the changeColor function to apply the new color
}
    

    
    // Function to convert hex to HSL
function hexToHSL(hex) {
    let r = 0, g = 0, b = 0;
    // Convert hex to RGB
    if (hex.length === 4) {
        r = parseInt(hex[1] + hex[1], 16);
        g = parseInt(hex[2] + hex[2], 16);
        b = parseInt(hex[3] + hex[3], 16);
    } else if (hex.length === 7) {
        r = parseInt(hex[1] + hex[2], 16);
        g = parseInt(hex[3] + hex[4], 16);
        b = parseInt(hex[5] + hex[6], 16);
    }
    // Convert RGB to HSL
    r /= 255, g /= 255, b /= 255;
    const max = Math.max(r, g, b), min = Math.min(r, g, b);
    let h, s, l = (max + min) / 2;
    if (max === min) {
        h = s = 0;
    } else {
        const d = max - min;
        s = l > 0.5 ? d / (2 - max - min) : d / (max + min);
        switch (max) {
            case r:
                h = (g - b) / d + (g < b ? 6 : 0);
                break;
            case g:
                h = (b - r) / d + 2;
                break;
            case b:
                h = (r - g) / d + 4;
                break;
        }
        h /= 6;
    }
    return [h * 360, s, l];
}

// Function to convert HSL to hex
function hslToHex(h, s, l) {
    let r, g, b;
    if (s === 0) {
        r = g = b = l;
    } else {
        const hue2rgb = (p, q, t) => {
            if (t < 0) t += 1;
            if (t > 1) t -= 1;
            if (t < 1 / 6) return p + (q - p) * 6 * t;
            if (t < 1 / 2) return q;
            if (t < 2 / 3) return p + (q - p) * (2 / 3 - t) * 6;
            return p;
        };
        const q = l < 0.5 ? l * (1 + s) : l + s - l * s;
        const p = 2 * l - q;
        r = hue2rgb(p, q, h + 1 / 3);
        g = hue2rgb(p, q, h);
        b = hue2rgb(p, q, h - 1 / 3);
    }
    const toHex = x => {
        const hex = Math.round(x * 255).toString(16);
        return hex.length === 1 ? '0' + hex : hex;
    };
    return `#${toHex(r)}${toHex(g)}${toHex(b)}`;
}
    
    </script>
@endsection