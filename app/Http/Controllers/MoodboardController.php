<?php

namespace App\Http\Controllers;

use App\Models\Moodboard;
use Illuminate\Http\Request;
use App\Models\MoodboardPhoto;
use App\Models\ColorCard;


class MoodboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $moodboard = Moodboard::with(['moodboard_photos', 'color_cards'])->first();
        $colorCards = ColorCard::pluck('hexcode');
        return view('moodboard.dashboard', compact('moodboard', 'colorCards'));
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
     

     public function create(Request $request)
     {
         // Validate the incoming request
         $request->validate([
             'name' => 'required|string',
             'description' => 'required|string',
             'hex' => 'required|string',
             'hue' => 'required|numeric',
             'saturation' => 'required|numeric',
             'brightness' => 'required|numeric',
         ]);
     
         // Create a new moodboard entry
         $moodboard = new Moodboard();
         $moodboard->name = $request->name;
         $moodboard->description = $request->description;
         $moodboard->save();
     
         // Create a new color card entry
         $colorCard = new ColorCard();
         $colorCard->hexcode = $request->hex;
         $colorCard->moodboard_id = $moodboard->id;
         $colorCard->save();
     
         // You can also save other properties of color card like hue, saturation, and brightness
         // Assuming these properties are also present in the ColorCard model
     
         // Redirect back with success message
         return redirect()->back()->with('success', 'Moodboard created successfully.');
     }
     
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'hex' => 'required|string',
            'hue' => 'required|numeric',
            'saturation' => 'required|numeric',
            'brightness' => 'required|numeric',
        ]);
    
        // Create a new moodboard entry
        $moodboard = new Moodboard();
        $moodboard->name = $request->name;
        $moodboard->description = $request->description;
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
