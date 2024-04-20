<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class LogoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        DB::table('logo')->where('status', 1)->update(['status' => 0]);

        $file = $request->file('image');
        $imagePath = $file->store('public/images');

        DB::table('logo')->insert([
            'image_name' => $file->getClientOriginalName(),
            'image_path' => $imagePath,
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['message' => 'Logo uploaded successfully'], 201);
    }

    public function displayImage()
    {
        $image = DB::table('logo')->where('status', 1)->first();

        if (!$image) {
            abort(404);
        }

        $imageUrl = Storage::url($image->image_path);
        return response()->json(['image_url' => $imageUrl]);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
