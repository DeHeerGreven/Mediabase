<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{

    public function showVideoPage(Request $request)
    {
        $videoPath = 'storage/' . $request->videoPath; //
        return view('videos.video-edit', ['videoPath' => $videoPath]);
    }

    public function uploadVideo(Request $request)
    {
        $request->validate([
            'video' => 'required|file|mimes:mp4,mov,avi',
        ]);
    
        $videoPath = $request->file('video')->store('videos', 'public');
    
        return redirect()->route('videos.video-edit', ['videoPath' => $videoPath]);
    }

    public function deleteVideo(Request $request)
    {
       
        $videoPath = $request->videoPath;
        $videoPath = explode("/", $videoPath)[count(explode("/", $videoPath))-1];
        $videoPath = 'public/videos/' . $videoPath;
        Storage::delete($videoPath);
    
        return redirect()->route('videos.video-edit')->with('success', 'Video deleted successfully.');
    }
}
