<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Http\Controllers\StorageController;


Route::get('/', [ImageController::class, 'index'])->name('home');

// Route to render the form or trigger image generation
Route::match(['get', 'post'], '/generate', [ImageController::class, 'generateImage'])->name('generate.image');
// Route to generate image via API
Route::get('/api/generate/{prompt}', [ApiController::class, 'index'])->name('api.generate');
// Route to display the image in the view
Route::get('/display-image', function (Request $request) {
    $imageUrl = $request->query('imageUrl');
    return view('display-image', compact('imageUrl'));
})->name('image.display');
// Route to serve stored images from the "Assets" directory
Route::get('/storage/Assets/{filename}', [StorageController::class, 'show'])->name('storage.assets');

Route::post('/save-edited-image', [ImageController::class, 'saveEditedImage'])->name('save.edited.image');




