<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Videos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('uploadVideo') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="video">
                        <button class="border-2 p-2" type="submit">Upload Video</button>
                    </form>
                </div>
                {{-- @dd($videoPath) --}}
                <video id="my-video" controls class="mx-auto">
                    <source src="{{ asset($videoPath) }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                <div class="p-6 text-gray-900">
                    <form action="{{ route('delete-video', ['videoPath' => asset($videoPath)]) }}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit">Delete Video</button>
                    </form>
                </div>
                <div class="p-6 text-gray-900">
                    <div id="selection-bar">
                        <div id="start-handle" class="handle"></div>
                        <div id="end-handle" class="handle"></div>
                        <div id="progress-bar"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>

<style>
    #video-container {
        position: relative;
    }

    #selection-bar {
        position: absolute;
        left: 18;
        width: 77%;
        height: 5px;
        background-color: #007bff;
        cursor: pointer;
    }

    .handle {
        position: absolute;
        top: -10px;
        width: 10px;
        height: 20px;
        background-color: #007bff;
        cursor: pointer;
    }

    #start-handle {
        left: 0;
    }

    #end-handle {
        right: 0;
    }

    #progress-bar {
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        background-color: #ccc;
    }

</style>

<script>
    var video = document.getElementById('my-video');
    var selectionBar = document.getElementById('selection-bar');
    var startHandle = document.getElementById('start-handle');
    var endHandle = document.getElementById('end-handle');
    var progressBar = document.getElementById('progress-bar');

    console.log(video); // Voeg deze regel toe
    console.log(stopVideo); // Voeg deze regel toe

    function stopVideo() {
        console.log('stopVideo function called');
        console.log('video.currentTime:', video.currentTime);
        console.log('endHandle.offsetLeft:', endHandle.offsetLeft);
        console.log('selectionBar.offsetWidth:', selectionBar.offsetWidth);
        console.log('video.duration:', video.duration);
        console.log('startHandle.offsetLeft:', startHandle.offsetLeft);
        console.log('video.paused:', video.paused);

        var startHandlePosition = (startHandle.offsetLeft - selectionBar.offsetLeft) / selectionBar.offsetWidth * video.duration;

        if (video.currentTime >= endHandle.offsetLeft / selectionBar.offsetWidth * video.duration &&
            video.currentTime <= startHandlePosition) {
            video.pause();
        }
    }


    

    startHandle.addEventListener('mousedown', function(event) {
        var startX = event.clientX;
        var startLeft = startHandle.offsetLeft;

        document.addEventListener('mousemove', onMouseMove);

        function onMouseMove(event) {
            var deltaX = event.clientX - startX;
            var newLeft = startLeft + deltaX;

            if (newLeft < 0) {
                newLeft = 0;
            } else if (newLeft > endHandle.offsetLeft) {
                newLeft = endHandle.offsetLeft;
            }

            startHandle.style.left = newLeft + 'px';
            progressBar.style.left = newLeft + 'px';
            video.currentTime = newLeft / selectionBar.offsetWidth * video.duration;

            stopVideo();
        }

        document.addEventListener('mouseup', function() {
            document.removeEventListener('mousemove', onMouseMove);
            video.removeEventListener('timeupdate', stopVideo);
            stopVideo();
        });
    });

    endHandle.addEventListener('mousedown', function(event) {
        var startX = event.clientX;
        var startRight = selectionBar.offsetWidth - endHandle.offsetLeft;

        document.addEventListener('mousemove', onMouseMove);

        function onMouseMove(event) {
            var deltaX = startX - event.clientX;
            var newRight = startRight + deltaX;

            if (newRight < 0) {
                newRight = 0;
            } else if (newRight > startHandle.offsetLeft) {
                newRight = startHandle.offsetLeft;
            }

            endHandle.style.right = newRight + 'px';
            progressBar.style.right = newRight + 'px';
            video.currentTime = (selectionBar.offsetWidth - newRight) / selectionBar.offsetWidth * video.duration;
        }

        document.addEventListener('mouseup', function() {
            document.removeEventListener('mousemove', onMouseMove);
            video.removeEventListener('timeupdate', stopVideo);
            stopVideo(); // Roep de stopVideo-functie aan wanneer de gebruiker de video inkort
    });
    

});
</script>
