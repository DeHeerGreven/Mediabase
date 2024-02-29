<?php

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
Route::post('/upload-video', [VideoController::class, 'uploadVideo'])->name('uploadVideo');
Route::delete('/delete-video', [VideoController::class, 'deleteVideo'])->name('delete-video');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::resource('projects', ProjectsController::class)
    ->middleware(['auth', 'verified']);

    
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
