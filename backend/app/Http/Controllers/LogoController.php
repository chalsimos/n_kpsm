<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\Logo;

class LogoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function deleteLogo(Request $request, $id)
    {
        try {
            $logo = Logo::findOrFail($id);
            if ($logo->status === 1) {
                return response()->json(['error' => 'Cannot delete active logo'], 400);
            }
            $logo->delete();
            return response()->json(['message' => 'Logo deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function activeLogo(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            Logo::where('status', 1)->update(['status' => 0]);
            $logo = Logo::findOrFail($id);
            if ($logo->status === 1) {
                return response()->json(['error' => 'Logo is already active'], 400);
            }
            $logo->status = 1;
            $logo->save();
            DB::commit();
            return response()->json(['message' => 'Logo updated successfully'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function index()
    {
        try {
            $logos = Logo::all();
            $imageUrls = $logos->map(function ($logo) {
                return [
                    'id' => $logo->id,
                    'image_path' => Storage::url($logo->image_path),
                    'status' => $logo->status,
                ];
            });
            return response()->json($imageUrls, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        try {
            DB::beginTransaction();
            Logo::where('status', 1)->update(['status' => 0]);
            $file = $request->file('image');
            $imagePath = $file->store('public/images');
            $logo = new Logo();
            $logo->image_name = $file->getClientOriginalName();
            $logo->image_path = $imagePath;
            $logo->status = 1;
            $logo->save();
            DB::commit();
            return response()->json(['message' => 'Logo uploaded successfully'], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function displayImage()
    {
        $logo = Logo::where('status', 1)->first();
        if (!$logo) {
            abort(404);
        }
        $imageUrl = Storage::url($logo->image_path);
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
