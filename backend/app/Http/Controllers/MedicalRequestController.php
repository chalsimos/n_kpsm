<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\MedicalRequest;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class MedicalRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function hospitalsWithServiceOffers()
     {
         try {
             $hospitals = Hospital::with('hospitalRequests')
                 ->where('status', 'active')
                 ->whereNull('deleted_at')
                 ->orderBy('status', 'asc')
                 ->get();
             $formattedHospitals = $hospitals->map(function ($hospital) {
                 return [
                     'id' => $hospital->id,
                     'hospital_name' => $hospital->hospital_name,
                     'hospital_acronym' => $hospital->hospital_acronym,
                     'service_offers' => $hospital->hospitalRequests->where('status','active')->pluck('service_offer')
                 ];
             });
             return response()->json($formattedHospitals, 200);
         } catch (\Exception $e) {
             return response()->json(['error' => $e->getMessage()], 500);
         }
     }


    public function index()
    {
        try {
            $medicalRequests = MedicalRequest::get();
            return response()->json($medicalRequests, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function requirementsPath(Request $request, $id)
    {
        try {
            $medicalRequest = MedicalRequest::findOrFail($id);
            $requestData = $medicalRequest->toArray();
            $imageUrls = [
                'barangay_clearance_imagepath' => [],
                'valid_id_imagepath' => [],
                'hospital_document_imagepath' => [],
            ];
            foreach ($imageUrls as $key => $imagePaths) {
                $imagePaths = explode(',', $requestData[$key]);
                foreach ($imagePaths as $imagePath) {
                    $imageUrl = asset($imagePath);
                    $imageUrls[$key][] = $imageUrl;
                }
            }
            $responseData = array_merge($requestData, $imageUrls);
            return response()->json($responseData);
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
            'contactnumber' => 'required|max:11',
            'diagnosis' => 'required|string|max:255',
            'hospital' => 'required|string|max:255',
            'request' => 'required|string|max:255',
            'brgy_ClearanceImages.*' => 'image',
            'valid_IdImages.*' => 'image',
            'hospital_DocumentImages.*' => 'image',
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
            $basePath = 'Request/Medical Request/' . now()->year . '/' . now()->format('F') . '/';
            $directoryPath = public_path($basePath . $request->input('municipality') . '/' . $request->input('barangay') . '/' . $request->input('hospital') . '/' . $request->input('request') . '/' . $data->lastname . ' ' . $data->middlename . ' ' . $data->firstname . '/' . now()->year . ' ' . now()->format('F') . ' ' . now()->format('d') . '/');
            if (!File::isDirectory($directoryPath)) {
                File::makeDirectory($directoryPath, 0700, true);
            }
            $brgyClearanceImagePaths = [];
            $validIdImagePaths = [];
            $hospitalDocumentImagePaths = [];
            if ($request->hasFile('brgy_ClearanceImages')) {
                foreach ($request->file('brgy_ClearanceImages') as $image) {
                    $imageName = 'brgy_Clearance_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $imagePath = $basePath . $request->input('municipality') . '/' . $request->input('barangay') . '/' . $request->input('hospital') . '/' . $request->input('request') . '/' . $data->lastname . ' ' . $data->middlename . ' ' . $data->firstname . '/' . now()->year . ' ' . now()->format('F') . ' ' . now()->format('d') . '/' . $imageName;
                    if (!in_array($imagePath, $brgyClearanceImagePaths)) {
                        $image->move($directoryPath, $imageName);
                        $brgyClearanceImagePaths[] = $imagePath;
                    }
                }
            }
            if ($request->hasFile('valid_IdImages')) {
                foreach ($request->file('valid_IdImages') as $image) {
                    $imageName = 'valid_id_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $imagePath = $basePath . $request->input('municipality') . '/' . $request->input('barangay') . '/' . $request->input('hospital') . '/' . $request->input('request') . '/' . $data->lastname . ' ' . $data->middlename . ' ' . $data->firstname . '/' . now()->year . ' ' . now()->format('F') . ' ' . now()->format('d') . '/' . $imageName;
                    if (!in_array($imagePath, $validIdImagePaths)) {
                        $image->move($directoryPath, $imageName);
                        $validIdImagePaths[] = $imagePath;
                    }
                }
            }
            if ($request->hasFile('hospital_DocumentImages')) {
                foreach ($request->file('hospital_DocumentImages') as $image) {
                    $imageName = 'hospital_documents_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $imagePath = $basePath . $request->input('municipality') . '/' . $request->input('barangay') . '/' . $request->input('hospital') . '/' . $request->input('request') . '/' . $data->lastname . ' ' . $data->middlename . ' ' . $data->firstname . '/' . now()->year . ' ' . now()->format('F') . ' ' . now()->format('d') . '/' . $imageName;
                    if (!in_array($imagePath, $hospitalDocumentImagePaths)) {
                        $image->move($directoryPath, $imageName);
                        $hospitalDocumentImagePaths[] = $imagePath;
                    }
                }
            }
            $data->update([
                'barangay_clearance_imagepath' => implode(',', $brgyClearanceImagePaths),
                'valid_id_imagepath' => implode(',', $validIdImagePaths),
                'hospital_document_imagepath' => implode(',', $hospitalDocumentImagePaths),
            ]);
            $horCode = 'AVU-' . now()->year . '-' . str_replace(' ', '-', $request->input('hospital')) . '-' . $data->id;
            $data->update(['Hor_code' => $horCode]);
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
