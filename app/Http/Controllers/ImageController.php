<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ImageController extends Controller
{
    public function index()
    {
        return view('image.index');
    }
    public function generateImage(Request $request)
    {

        $request->validate([
            'role' => 'required|in:bowler,batsman,wicket-keeper,fielder',
            'ballType' => 'required|in:white ball,red ball,pink ball',
        ]);


        // Retrieve form inputs
        $role = $request->input('role');
        $ballType = $request->input('ballType');
        $extraPrompt = $request->input('extraPrompt', '');

        // Build the action description based on role
        $actionDescription = match ($role) {
            'bowler' => 'captured at the moment of release',
            'batsman' => 'captured at the moment of the bat hitting the ball',
            'wicket-keeper' => 'captured while the ball is going inside the gloves',
            default => 'fielder diving to catch the ball',
        };

        // Build the final prompt
        $finalPrompt = "Poster, {$role} in action, {$ballType}, {$actionDescription}, dramatic lighting, 4k, masterpiece";
        if (!empty($extraPrompt)) {
            $finalPrompt .= ", {$extraPrompt}";
        }

        // Log or return the prompt for testing
        Log::info("Generated prompt: {$finalPrompt}");

        return redirect()->route('api.generate', ['prompt' => urlencode($finalPrompt)]);
    }
    public function saveEditedImage(Request $request)
    {
        // Validate incoming request to ensure it contains valid image data
        $request->validate([
            'imageData' => 'required|string', // Base64 encoded image data
        ]);

        // Get the base64 image data from the request
        $imageData = $request->input('imageData');
        
        // Remove base64 prefix (if exists) to store only the raw data
        if (preg_match('/^data:image\/(\w+);base64,/', $imageData, $matches)) {
            $imageData = substr($imageData, strpos($imageData, ',') + 1);
        }

        // Decode the base64 image data
        $imageData = base64_decode($imageData);

        // Generate a filename for the new image
        $imageName = 'edited_image_' . time() . '.png';

        // Store the image in the 'public/edited_images' folder
        $path = Storage::disk('public')->put('edited_images/' . $imageName, $imageData);

        // Return the image URL to download the saved image
        return response()->json([
            'success' => true,
            'imageUrl' => Storage::url('edited_images/' . $imageName),
        ]);
    }
}
