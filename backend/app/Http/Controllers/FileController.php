<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
    public function uploadFile(Request $request)
    {
        // Validate the request
        $request->validate([
            'file' => 'required|mimes:jpeg,jpg,png|max:2048'
        ]);

        // Handle the file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $destinationPath = public_path('/uploads');

            // Move the file to the public/uploads directory
            $file->move($destinationPath, $fileName);

            return response()->json([
                'message' => 'File uploaded successfully',
                'path' => url('/uploads/' . $fileName) // Generates the public URL
            ], 200);
        }

        return response()->json(['message' => 'No file uploaded'], 400);
    }
    
}
