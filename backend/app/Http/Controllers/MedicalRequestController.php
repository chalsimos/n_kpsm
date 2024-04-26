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
                'id'
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
            'firstname' => 'required|string|max:255',
            'middlename' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'age' => 'required|integer|min:0',
            'birthday' => 'required|date',
            'gender' => 'required|string|in:Male,Female',
            'province' => 'required|string|max:255',
            'municipality' => 'required|string|max:255',
            'barangay' => 'required|string|max:255',
            'representativefullname' => 'required|string|max:255',
            'contactnumber' => 'required|string|max:11',
            'diagnosis' => 'required|string|max:255',
            'hospital' => 'required|string|max:255',
            'request' => 'required|string|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        try {
            DB::beginTransaction();
            $data = new MedicalRequest();
            $data->firstname = $request->input('firstname');
            $data->middlename = $request->input('middlename');
            $data->lastname = $request->input('lastname');
            $data->age = $request->input('age');
            $data->birthday = $request->input('birthday');
            $data->gender = $request->input('gender');
            $data->province = $request->input('province');
            $data->municipality = $request->input('municipality');
            $data->barangay = $request->input('barangay');
            $data->representativefullname = $request->input('representativefullname');
            $data->contactnumber = $request->input('contactnumber');
            $data->diagnosis = $request->input('diagnosis');
            $data->hospital = $request->input('hospital');
            $data->request = $request->input('request');
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
    public function approve_amount(Request $request, $id)
    {
        try {
            $medicalRequest = MedicalRequest::findOrFail($id);
            $validatedData = $request->validate([
                'amount' => 'required|numeric',
            ]);
            $medicalRequest->amount = $validatedData['amount'];
            if ($medicalRequest->save()) {
                $medicalRequest->status = 'approve';
                $medicalRequest->save();
                return response()->json(['data' => $medicalRequest], 200);
            } else {
                return response()->json(['error' => 'Failed to update amount'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }
    public function decline(Request $request, $id)
    {
        try {
            $medicalRequest = MedicalRequest::findOrFail($id);
            $validatedData = $request->validate([
                'decline_reason' => 'required|string',
            ]);
            $medicalRequest->decline_reason = $validatedData['decline_reason'];
            if ($medicalRequest->save()) {
                $medicalRequest->status = 'decline';
                $medicalRequest->save();
                return response()->json(['data' => $medicalRequest], 200);
            } else {
                return response()->json(['error' => 'Failed to update amount'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
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
