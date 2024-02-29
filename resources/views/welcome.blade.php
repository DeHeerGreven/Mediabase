@extends('layouts.app')

@section('content')
    <div class="flex justify-center items-center h-screen">
        <div class="text-center w-3/4">
            <h1 class="text-green-500 mb-4 font-bold text-5xl">Welkom op MediaBase!</h1>
            <p class="font-regular text-xl mb-6">Hieronder kan je op de knop klikken om jouw projecten bekijken.</p>
            <a href="{{route('projects.index')}}" class="bg-green-500 text-lg text-white rounded-lg py-2 px-4">Bekijk projecten</a>
        </div>
    </div>
@endsection