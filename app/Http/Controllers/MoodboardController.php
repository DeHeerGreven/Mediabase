<?php

namespace App\Http\Controllers;

use App\Models\Moodboard;
use Illuminate\Http\Request;
use App\Models\MoodboardPhoto;
use App\Models\ColorCard;
use App\Models\Project;

class MoodboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($project) {
        $moodboard = Moodboard::with(['moodboard_photos', 'color_cards'])->first();
        $colorCards = ColorCard::pluck('hexcode');
        return view('moodboard.dashboard', compact('moodboard', 'colorCards', 'project'));
    }
    
    /**
     * Show the form for creating a new resource.
     */

     public function upload(Request $request)
     {
         // Validate the incoming request
         $request->validate([
             'image.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validation rules for each image
         ]);
     
         // Check if the request contains files
         if ($request->hasFile('image')) {
             foreach ($request->file('image') as $image) {
                 // Store each uploaded file
                 $imageName = time() . '_' . $image->getClientOriginalName();
                 $image->storeAs('public/moodboard', $imageName);
     
                 // Save the file path to the database
                 $moodboardPhoto = new MoodboardPhoto();
                 $moodboardPhoto->image_path = 'storage/moodboard/' . $imageName;
                 $moodboardPhoto->moodboard_id = 1; // Assuming moodboard ID
                 $moodboardPhoto->save();
             }
     
             return redirect()->back()->with('success', 'Images uploaded successfully.');
         }
     
         return redirect()->back()->with('error', 'Failed to upload images.');
     }
     

     public function create(Request $request, $projectId)
        {

            $project = Project::findOrFail($projectId);
            // Validate the incoming request
            $request->validate([
                'name' => 'required|string',
                'description' => 'required|string',
                'hex' => 'required|string',
            ]);
            // Create a new moodboard entry
            $moodboard = new Moodboard();
            $moodboard->name = $request->name;
            $moodboard->description = $request->description;
            $moodboard->project_id = $project->id;
            $moodboard->save();
            
            // Create a new color card entry
            $colorCard = new ColorCard();
            $colorCard->hexcode = $request->hex;
            $colorCard->moodboard_id = $moodboard->id;
            $colorCard->save();
            
            // Redirect back with success message
            return redirect()->back()->with('success', 'Moodboard created successfully.');
        }
    /**
     * Store a newly created resource in storage.
     */

    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
