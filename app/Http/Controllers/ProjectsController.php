<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
             // Haal alle klanten op
             $projects = Project::all();
             // Laat klantoverzicht zien
             return view('projects.dashboard', ['projects' => $projects]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:Not done,Done',
            'type' => 'required|in:video,photo,moodboard',
        ]);
    
        // Create a new project instance with the validated data
        Project::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'status' => $validatedData['status'],
            'type' => $validatedData['type'],
        ]);
    
        // Optionally, you can return a response to the user
        return redirect()->route('projects.index')->with('success', 'Project created successfully');
    }
    
    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $project = Project::findOrFail($id);

    // Check the project type and redirect to the appropriate view
        if ($project->type === 'video') {
            return redirect()->route('videos.show-video', $project->id);
        } elseif ($project->type === 'moodboard') {
            return redirect()->route('moodboard.index', $project->id);
        } elseif ($project->type === 'photo'){
            return view('edit-photo')->with($project->id);
        
        } else {
            // Handle other types or provide a default view
            return view('projects.show', compact('project'));
        }
        return view('projects.show', compact('project'));
    
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $project = Project::findOrFail($id);
        return view('projects.edit')->with([
            'project' => $project
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        // Valideer en sla de bewerkte gegevens op
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'status' => 'required',
            'type' => 'required|in:video,photo,moodboard',
            // Voeg hier andere gevalideerde velden toe
        ]);

        // Update de afspraak met de nieuwe gegevens
        $project->update($validatedData);

        // Redirect terug naar de detailpagina na bewerken
        return redirect()->route('projects.index', $project->id);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();
    
        return redirect()->route('projects.index')->with('success', 'Project deleted successfully.');
    }
}
