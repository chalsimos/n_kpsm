<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FileModel;
class FileController extends Controller
{
    public function update(Request $request, $id)
    {
        $file = FileModel::findOrFail($id);
        $file->update($request->all());

        return response()->json([
            'message' => 'Image updated successfully',
            'file' => $file,
        ]);
    }
    public function getImages(){
        // $files = FileModel::get();
        // return response()->json(['data' =>$files]);
        $files = FileModel::all();
        $images = $files->map(function ($file) {
            return [
                'id' => $file->id,
                'url' => asset('storage/' . $file->location),
                'caption' => $file->caption
            ];
        });
        return response()->json($images, 200);
    }
    public function findimage(Request $request, $id)
    {
        // $files = FileModel::where('news_id', $id)
        //                   ->where('status', 'active')
        //                   ->get();
       $images = FileModel::where('news_id', $id)
                            ->where('status', 'active')
                            ->get();
    return response()->json($images);
    }
    public function uploadFile(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('uploads', 'public');
            
            // Save file info to database
            $fileModel = new FileModel();
            $fileModel->location = $path;
            $fileModel->save();

            return response()->json(['success' => true, 'path' => $path], 200);
        }
        return response()->json(['success' => false], 400);
    }

    // public function uploadFile(Request $request)
    // {
    //     // Validate the request
    //     $request->validate([
    //         'file' => 'required|mimes:jpeg,jpg,png|max:2048'
    //     ]);

    //     // Handle the file upload
    //     if ($request->hasFile('file')) {
    //         $file = $request->file('file');
    //         $fileName = time() . '_' . $file->getClientOriginalName();
    //         $destinationPath = public_path('/uploads');

    //         // Move the file to the public/uploads directory
    //         $file->move($destinationPath, $fileName);

    //         return response()->json([
    //             'message' => 'File uploaded successfully',
    //             'path' => url('/uploads/' . $fileName) // Generates the public URL
    //         ], 200);
    //     }

    //     return response()->json(['message' => 'No file uploaded'], 400);
    // }
    
}
