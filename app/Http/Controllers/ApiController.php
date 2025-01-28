<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ApiController extends Controller
{
    public function index($prompt)
    {
        $decodedPrompt = urldecode($prompt);
        print($decodedPrompt);
        // API Endpoint and Key Configuration
        $url = env('API_URL');
        $apiKey = env('API_KEY');

        if (!$apiKey) {
            throw new \Exception('STABILITY_API_KEY is not set in the environment file.');
        }

        $payload = [
            'prompt' => $decodedPrompt,
            'output_format' => 'png',
            'number' => '1',           
            'model' => 'sd3.5-medium',
            'aspect_ratio' => '4:5',
            'style_preset' => 'cinematic',
        ];

        try {

            // Make the API request
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$apiKey}",
                'Accept' => 'image/*',
            ])->asMultipart()->post($url, $payload);


            // Check if the API call was successful
            if ($response->successful()) {

                $imageName = 'Banner_' . uniqid() . '.png';
                $storagePath = "Assets/{$imageName}";
                Storage::disk('public')->put($storagePath, $response->body());
                $imageUrl = asset("storage/{$storagePath}");


                // Return the view with the image URL
                return redirect()->route('image.display', ['imageUrl' => $imageUrl]);
            } else {
                return response()->json(['error' => $response->status() . ': ' . $response->body()], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
