@extends('layouts.app')

@section('content')
<div class="container disable">
    <h2 class="mt-0 mb-6 text-lg font-medium">Easy Image Editor</h2>
    <div class="flex flex-wrap -mx-4">
        <div class="w-full md:w-1/2 px-4">
            <div class="p-6 rounded border border-gray-300">
                <label class="block text-sm font-medium mb-3">Filters</label>
                <div class="flex flex-wrap -mx-2 mb-4">
                    <button id="brightness" class="active filter-btn">Brightness</button>
                    <button id="saturation" class="filter-btn">Saturation</button>
                    <button id="inversion" class="filter-btn">Inversion</button>
                    <button id="grayscale" class="filter-btn">Grayscale</button>
                </div>
                <div class="mb-6">
                    <div class="flex justify-between text-sm text-gray-600">
                        <p class="name">Brighteness</p>
                        <p class="value">100%</p>
                    </div>
                    <input type="range" id="filter-slider" value="100" min="0" max="200" class="w-full">
                </div>
            </div>
            <div class="p-6 rounded border border-gray-300 mt-6">
                <label class="block text-sm font-medium mb-3">Rotate & Flip</label>
                <div class="flex justify-between">
                    <button id="left" class="rotate-btn"><i class="fas fa-rotate-left"></i></button>
                    <button id="right" class="rotate-btn"><i class="fas fa-rotate-right"></i></button>
                    <button id="horizontal" class="rotate-btn"><i class='bx bx-reflect-vertical'></i></button>
                    <button id="vertical" class="rotate-btn"><i class='bx bx-reflect-horizontal'></i></button>
                </div>
            </div>
        </div>
        <div class="w-full md:w-1/2 px-4">
            <div class="p-6 rounded border border-gray-300 preview-img">
                <img id="preview-img" src="image-placeholder.svg" alt="preview-img" class="w-full h-auto">
            </div>
        </div>
    </div>
    <div class="flex items-center justify-between mt-6">
        <button id="reset-filter-btn" class="text-gray-700 border border-gray-700 py-2 px-4 rounded transition duration-300 hover:bg-gray-700 hover:text-white">Reset Filters</button>
        <div class="flex items-center space-x-4">
            <input type="file" id="file-input" class="hidden">
            <button id="choose-img-btn" class="bg-gray-700 text-white py-2 px-4 rounded transition duration-300 hover:bg-gray-800">Choose Image</button>
            <button id="save-img-btn" class="bg-blue-500 text-white py-2 px-4 rounded transition duration-300 hover:bg-blue-600">Save Image</button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    const fileInput = document.getElementById("file-input");
    const filterOptions = document.querySelectorAll(".filter-btn");
    const filterName = document.querySelector(".name");
    const filterValue = document.querySelector(".value");
    const filterSlider = document.getElementById("filter-slider");
    const rotateOptions = document.querySelectorAll(".rotate-btn");
    const previewImg = document.getElementById("preview-img");
    const resetFilterBtn = document.getElementById("reset-filter-btn");
    const chooseImgBtn = document.getElementById("choose-img-btn");
    const saveImgBtn = document.getElementById("save-img-btn");

    let brightness = "100", saturation = "100", inversion = "0", grayscale = "0";
    let rotate = 0, flipHorizontal = 1, flipVertical = 1;

    const loadImage = () => {
        let file = fileInput.files[0];
        if (!file) return;
        previewImg.src = URL.createObjectURL(file);
        previewImg.addEventListener("load", () => {
            resetFilterBtn.click();
            document.querySelector(".container").classList.remove("disable");
        });
    }

    const applyFilter = () => {
        previewImg.style.transform = `rotate(${rotate}deg) scale(${flipHorizontal}, ${flipVertical})`;
        previewImg.style.filter = `brightness(${brightness}%) saturate(${saturation}%) invert(${inversion}%) grayscale(${grayscale}%)`;
    }

    filterOptions.forEach(option => {
        option.addEventListener("click", () => {
            document.querySelector(".active").classList.remove("active");
            option.classList.add("active");
            filterName.innerText = option.innerText;

            if (option.id === "brightness") {
                filterSlider.max = "200";
                filterSlider.value = brightness;
                filterValue.innerText = `${brightness}%`;
            } else if (option.id === "saturation") {
                filterSlider.max = "200";
                filterSlider.value = saturation;
                filterValue.innerText = `${saturation}%`
            } else if (option.id === "inversion") {
                filterSlider.max = "100";
                filterSlider.value = inversion;
                filterValue.innerText = `${inversion}%`;
            } else {
                filterSlider.max = "100";
                filterSlider.value = grayscale;
                filterValue.innerText = `${grayscale}%`;
            }
        });
    });

    const updateFilter = () => {
        filterValue.innerText = `${filterSlider.value}%`;
        const selectedFilter = document.querySelector(".filter-btn.active");

        if (selectedFilter.id === "brightness") {
            brightness = filterSlider.value;
        } else if (selectedFilter.id === "saturation") {
            saturation = filterSlider.value;
        } else if (selectedFilter.id === "inversion") {
            inversion = filterSlider.value;
        } else {
            grayscale = filterSlider.value;
        }
        applyFilter();
    }

    rotateOptions.forEach(option => {
        option.addEventListener("click", () => {
            if (option.id === "left") {
                rotate -= 90;
            } else if (option.id === "right") {
                rotate += 90;
            } else if (option.id === "horizontal") {
                flipHorizontal = flipHorizontal === 1 ? -1 : 1;
            } else {
                flipVertical = flipVertical === 1 ? -1 : 1;
            }
            applyFilter();
        });
    });

    const resetFilter = () => {
        brightness = "100"; saturation = "100"; inversion = "0"; grayscale = "0";
        rotate = 0; flipHorizontal = 1; flipVertical = 1;
        filterOptions[0].click();
        applyFilter();
    }

    const saveImage = () => {
        const canvas = document.createElement("canvas");
        const ctx = canvas.getContext("2d");
        canvas.width = previewImg.naturalWidth;
        canvas.height = previewImg.naturalHeight;

        ctx.filter = `brightness(${brightness}%) saturate(${saturation}%) invert(${inversion}%) grayscale(${grayscale}%)`;
        ctx.translate(canvas.width / 2, canvas.height / 2);
        if (rotate !== 0) {
            ctx.rotate(rotate * Math.PI / 180);
        }
        ctx.scale(flipHorizontal, flipVertical);
        ctx.drawImage(previewImg, -canvas.width / 2, -canvas.height / 2, canvas.width, canvas.height);

        const link = document.createElement("a");
        link.download = "image.jpg";
        link.href = canvas.toDataURL();
        link.click();
    }

    filterSlider.addEventListener("input", updateFilter);
    resetFilterBtn.addEventListener("click", resetFilter);
    saveImgBtn.addEventListener("click", saveImage);
    fileInput.addEventListener("change", loadImage);
    chooseImgBtn.addEventListener("click", () => fileInput.click());
});
</script>
@endsection
