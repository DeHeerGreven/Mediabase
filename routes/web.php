<?php

use App\Http\Controllers\MoodboardController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\VideoController;
use App\Http\Controllers\ProjectsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/videos/video-edit', [VideoController::class, 'showVideoPage'])->name('videos.video-edit');
Route::get('/videos/{id}', [VideoController::class, 'showVideoPage'])->name('videos.show-video');
Route::post('/upload-video', [VideoController::class, 'uploadVideo'])->name('uploadVideo');
Route::delete('/delete-video', [VideoController::class, 'deleteVideo'])->name('delete-video');


    

Route::resource('projects', ProjectsController::class)
    ->middleware(['auth', 'verified']);

    Route::middleware(['auth'])->group(function () {
    Route::get('/moodboard/{project}', [MoodboardController::class, 'index'])->name('moodboard.index');
        Route::post('/moodboard/upload', [MoodboardController::class, 'upload'])->name('moodboard.upload');
        Route::delete('/moodboard/delete', [MoodboardController::class, 'delete'])->name('moodboard.delete');
        Route::post('/moodboard/create/{projectId}', [MoodboardController::class, 'create'])->name('moodboard.create');
    });

    

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/projects/{id}/edit-photo', function () {
    return view('edit-photo');
});

require __DIR__.'/auth.php';
