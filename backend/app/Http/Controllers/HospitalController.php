<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;


class HospitalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $hospital = Hospital::orderBy('status', 'asc')->get();
            return response()->json($hospital, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }
    public function save_hospital(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'hospital_name' => 'required',
            'hospital_acronym' => 'required',
            'hospital_address' => 'required',
            'hospital_district' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        try {
            DB::beginTransaction();
            $data = new Hospital();
            $data->hospital_name = $request->input('hospital_name');
            $data->hospital_acronym = $request->input('hospital_acronym');
            $data->hospital_address = $request->input('hospital_address');
            $data->hospital_district = $request->input('hospital_district');
            $data->status = 'active';
            $data->save();
            DB::commit();
            return response()->json(['message' => 'Hospital saved successfully'], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function delete_hospital(Request $request, $id)
    {
        try {
            $hospital = Hospital::findOrFail($id);
            if ($hospital->status === 'active') {
                return response()->json(['error' => 'Cannot delete active hospital'], 400);
            }
            $hospital->delete();
            return response()->json(['message' => 'Hospital deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function active_hospital(string $id)
    {
        try {
            DB::beginTransaction();
            $Hospital = Hospital::findOrFail($id);
            $Hospital->status = 'active';
            $Hospital->save();
            DB::commit();
            return response()->json(['message' => 'Hospital updated successfully'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function deactivate_hospital(string $id)
    {
        try {
            DB::beginTransaction();
            $Hospital = Hospital::findOrFail($id);
            $Hospital->status = 'inactive';
            $Hospital->save();
            DB::commit();
            return response()->json(['message' => 'Hospital updated successfully'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function edit_hospital(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'hospital_name' => 'required',
            'hospital_acronym' => 'required',
            'hospital_address' => 'required',
            'hospital_district' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        try {
            DB::beginTransaction();
            $hospital = Hospital::findOrFail($id);
            $hospital->hospital_name = $request->input('hospital_name');
            $hospital->hospital_acronym = $request->input('hospital_acronym');
            $hospital->hospital_address = $request->input('hospital_address');
            $hospital->hospital_district = $request->input('hospital_district');
            $hospital->save();
            DB::commit();
            return response()->json(['message' => 'Hospital updated successfully'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
