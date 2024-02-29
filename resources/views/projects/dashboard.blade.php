@extends('layouts.app')

@section('content')

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<!-- Content -->
<div class="container mx-auto">
    <a href="{{ route('projects.create') }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded mt-8 inline-block" style="text-decoration: none;">Maak een nieuw project</a>
    <div class="grid grid-cols-3 gap-4 mt-8"> <!-- Added mt-8 class to add margin-top -->
        @foreach ($projects as $project)
        <div class="bg-white p-4 rounded shadow-md">
            <h1 class="text-2xl font-bold">{{$project->name}}</h1> 
            <p>{{$project->description}}</p>        
            <p>{{$project->status}}</p>       
        </div>
        @endforeach
    </div>
</div>

@endsection
