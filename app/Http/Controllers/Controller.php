<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;



    // For API
    protected function respondWithSuccess($message = '', $data = [], $code = 200)
    {
        return response()->json([
            'status'   => true,
            'errors'  => false,
            'message'  => $message,
            'data'     => $data
        ], $code);
    }
    protected function respondWithError($message, $data = [], $code = 203)
    {
        return response()->json([
            'status'   => false,
            'errors'  => true,
            'message'  => $message,
            'data'     => $data
        ], $code);
    }

    protected function getRandomBadge()
    {
        $badges = [
            "primary",
            "secondary",
            "success",
            "danger",
            "warning",
            "info",
        ];
        return $badges[rand(0, count($badges) - 1)];
    }


    protected function checkAuth()
    {
        if (!Auth::check()) {
            return redirect()->route('auth.login');
        }
    }


    protected function storeImage($image)
    {

        $GET_IMAGE = explode(";base64,", $image);
        if ($GET_IMAGE) {
            $img = $GET_IMAGE[1];
        }
        $data = base64_decode($img);
        $file_name = 'images/' . uniqid() . '.png';
        Storage::disk('public')->put($file_name, $data);
        $name = '/storage/' . $file_name;
        return $name;
    }


    protected function newStoreImage($image)
    {

        // Split the base64 image string
        $GET_IMAGE = explode(";base64,", $image);
        if (count($GET_IMAGE) < 2) {
            return 'Invalid image format';
        }

        $img = $GET_IMAGE[1];
        $data = base64_decode($img);

        if (!$data) {
            return 'Base64 decode failed';
        }

        // Create a unique temporary file name
        $tempFilePath = sys_get_temp_dir() . '/' . uniqid() . '.png';

        // Save the decoded image data to the temporary file
        file_put_contents($tempFilePath, $data);

        // Define the final file path in the public storage
        $file_name = 'images/' . uniqid() . '.png';
        $destinationPath = storage_path('app/public/' . $file_name);

        // Move the temporary file to the public storage path
        if (rename($tempFilePath, $destinationPath)) {
            // Ensure the file is publicly accessible
            return asset('storage/' . $file_name);
        } else {
            return 'Failed to move image to public storage';
        }
    }

}
