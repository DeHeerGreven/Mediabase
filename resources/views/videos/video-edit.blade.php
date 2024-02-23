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
                <video controls>
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
            </div>
        </div>

    </div>
</x-app-layout>
