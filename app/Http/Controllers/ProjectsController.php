<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        ]);
    
        // Create a new project instance with the validated data
        Project::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'status' => $validatedData['status'],
        ]);
    
        // Optionally, you can return a response to the user
        return redirect()->route('projects.index')->with('success', 'Project created successfully');
    }
    
    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editPhoto(Project $project)
    {
        $photo = $project->photo; // Retrieve the associated photo for the project
        
        return view('projects.edit-photo', compact('project', 'photo'));
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function savePhoto(Request $request, Project $project)
    {
        // Validate the incoming request
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust max file size as needed
        ]);

        // Get the uploaded image
        $image = $request->file('image');

        // Generate a unique filename for the image
        $filename = 'project_' . $project->id . '_' . time() . '.' . $image->getClientOriginalExtension();

        // Store the image file
        $imagePath = $image->storeAs('public/project_images', $filename);

        // Create a new photo record
        $photo = new Photo();
        $photo->image_path = 'storage/project_images/' . $filename;
        $photo->project_id = $project->id;
        $photo->save();

        return redirect()->route('projects.edit-photo', $project)->with('success', 'Photo uploaded and saved successfully.');
    }

    public function saveEditedPhoto(Request $request, Project $project)
    {
        // Retrieve the edited image data from the request
        $editedImageData = $request->input('image');

        // Save the edited image data to storage (example: replace the old image)
        // Example code: (ensure to adapt it to your storage mechanism)
        $imagePath = 'storage/project_images/edited_image.jpg';
        file_put_contents(public_path($imagePath), base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $editedImageData)));

        // Optionally, update the project record in the database if necessary
        // $project->update(['image_path' => $imagePath]);

        // Return a response (e.g., success message)
        return response()->json(['message' => 'Edited image saved successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
