<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\MedicalRequest;
use Illuminate\Support\Facades\DB;

class MedicalRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $medicalRequests = MedicalRequest::select([
                'firstname',
                'middlename',
                'lastname',
                'age',
                'birthday',
                'gender',
                'province',
                'municipality',
                'barangay',
                'representativefullname',
                'contactnumber',
                'diagnosis',
                'hospital',
                'request',
                'status',
                'amount',
            ])->get();

            return response()->json($medicalRequests, 200);
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
            'FirstName' => 'required|string|max:255',
            'MiddleName' => 'required|string|max:255',
            'LastName' => 'required|string|max:255',
            'Age' => 'required|integer|min:0',
            'Birthday' => 'required|date',
            'Gender' => 'required|string|in:male,female',
            'Province' => 'required|string|max:255',
            'Municipality' => 'required|string|max:255',
            'Barangay' => 'required|string|max:255',
            'FullName' => 'required|string|max:255',
            'ContactNumber' => 'required|string|max:255',
            'Diagnosis' => 'required|string|max:255',
            'Hospital' => 'required|string|max:255',
            'Request' => 'required|string|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        try {
            DB::beginTransaction();
            $data = new MedicalRequest();
            $data->firstname = $request->input('FirstName');
            $data->middlename = $request->input('MiddleName');
            $data->lastname = $request->input('LastName');
            $data->age = $request->input('Age');
            $data->birthday = $request->input('Birthday');
            $data->gender = $request->input('Gender');
            $data->province = $request->input('Province');
            $data->municipality = $request->input('Municipality');
            $data->barangay = $request->input('Barangay');
            $data->representativefullname = $request->input('FullName');
            $data->contactnumber = $request->input('ContactNumber');
            $data->diagnosis = $request->input('Diagnosis');
            $data->hospital = $request->input('Hospital');
            $data->request = $request->input('Request');
            $data->status = 'pending';
            $data->save();
            DB::commit();
            return response()->json(['message' => 'Medical Request saved successfully'], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $medicalRequest = MedicalRequest::findOrFail($id);
            return response()->json(['data' => $medicalRequest], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
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
