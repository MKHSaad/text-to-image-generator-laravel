<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class StorageController extends Controller
{
    //show image from storage
    public function show($filename)
    {
        $path = "Assets/{$filename}";
        if (!Storage::exists($path)) {
            abort(404);
        }
        return response(Storage::get($path),200)
            ->header('Content-Type', Storage::mimeType($path));
    }



}
