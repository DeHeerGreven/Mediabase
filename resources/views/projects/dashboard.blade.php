    @extends('layouts.app')

    @section('content')

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <!-- Content -->
    <div class="container mx-auto main-content"> <!-- Added main-content class here -->
        <a href="{{ route('projects.create') }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded mt-8 inline-block" style="text-decoration: none;">Maak een nieuw project</a>
        <div class="grid grid-cols-3 gap-4 mt-8"> <!-- Added mt-8 class to add margin-top -->
            @foreach ($projects as $project)
            <div class="bg-white p-4 rounded shadow-md">
                <h1 class="text-2xl font-bold">{{$project->name}}</h1> 
                <p>{{$project->description}}</p>        
                <p>{{$project->status}}</p>
                <p>{{ $project->type }}</p>
                <a href="{{ route('projects.show', $project->id) }}" class="bg-green-500 p-2 rounded-lg text-white" style="text-decoration: none">View Project</a>
                <a href="{{route('projects.edit', $project->id)}}" class="bg-green-500 p-2 rounded-lg text-white" style="text-decoration: none">Bewerken</a>
                <form action="{{ route('projects.destroy', $project->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 p-2 rounded-lg text-white" onclick="return confirm('Are you sure you want to delete this project?')">Delete</button>
                </form>
            </div>
            @endforeach
        </div>
    </div>

    @endsection
