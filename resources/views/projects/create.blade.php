@extends('layouts.app')

@section('content')

<div class="container mt-14">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    Create New Project
                </div>
                <div class="card-body">
                    @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif
                    <form method="POST" action="{{ route('projects.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="Not done">Not done</option>
                                <option value="Done">Done</option>
                            </select>
                        </div>     
                        <div class="form-group">
                            <label for="type">Project Type</label>
                            <select class="form-control" id="type" name="type" required>
                                <option value="video">Video</option>
                                <option value="photo">Foto</option>
                                <option value="moodboard">Moodboard</option>
                            </select>
                        </div>                 
                        <button type="submit" class="btn btn-primary mt-8">Create Project</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
