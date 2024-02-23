<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    public function editImage(Project $project)
    {
        // Assuming 'photos' is the relationship method in your Project model
        $photo = $project->photos()->first(); // Assuming a project has only one photo

        return view('projects.edit-image', compact('project', 'photo'));
    }

    public function updateImage(Request $request, Project $project)
    {
        // Validate the request

        // Assuming you update the photo directly in the photos table
        $photo = $project->photos()->first(); // Assuming a project has only one photo
        $photo->image_path = $request->file('image')->store('images');
        $photo->save();

        return redirect()->route('projects.edit-image', $project)->with('success', 'Image updated successfully.');
    }
}
