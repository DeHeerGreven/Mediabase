<?php

namespace App\Http\Controllers;

use App\Models\Moodboard;
use Illuminate\Http\Request;
use App\Models\MoodboardPhoto;


class MoodboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $moodboard = Moodboard::with('moodboard_photos')->first();
        return view('moodboard.dashboard', compact('moodboard'));
    }
    
    /**
     * Show the form for creating a new resource.
     */

   
     public function upload(Request $request)
     {
         // Validate the incoming request
         $request->validate([
             'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Example validation rules
         ]);
 
         // Check if the request contains a file
         if ($request->hasFile('image')) {
             // Store the uploaded file
             $image = $request->file('image');
             $imageName = time() . '_' . $image->getClientOriginalName();
             $image->storeAs('public/moodboard', $imageName);
 
             // Save the file path to the database
             $moodboardPhoto = new MoodboardPhoto();
             $moodboardPhoto->image_path = 'storage/moodboard/' . $imageName;
             $moodboardPhoto->moodboard_id = 1; // Assuming moodboard ID
             $moodboardPhoto->save();
 
             return redirect()->back()->with('success', 'Image uploaded successfully.');
         }
 
         return redirect()->back()->with('error', 'Failed to upload image.');
     }
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

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
