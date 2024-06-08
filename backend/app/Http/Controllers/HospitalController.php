<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use App\Models\HospitalRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class HospitalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $hospital = Hospital::get();
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
            'province' => 'required',
            'municipality' => 'required',
            'barangay' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        try {
            DB::beginTransaction();
            $data = new Hospital();
            $data->hospital_name = $request->input('hospital_name');
            $data->hospital_acronym = $request->input('hospital_acronym');
            $data->province = $request->input('province');
            $data->municipality = $request->input('municipality');
            $data->barangay = $request->input('barangay');
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

    //Hospital Request


    public function createHospitalRequest(Request $request, $id)
    {
        $validatedData = $request->validate([
            'service_offer' => 'required|string|max:255',
        ]);
        DB::beginTransaction();
        try {
            $hospital = Hospital::findOrFail($id);
            $hospitalRequest = new HospitalRequest();
            $hospitalRequest->hospital_id = $hospital->id;
            $hospitalRequest->service_offer = $validatedData['service_offer'];
            $hospitalRequest->status = 'active';
            $hospitalRequest->save();
            DB::commit();
            return response()->json($hospitalRequest, 201);
        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json(['error' => $e->errors()], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function hospitalsWithServiceOffers()
    {
        try {
            $hospitals = Hospital::with('hospitalRequests')->orderBy('status', 'asc')->get();
            $formattedHospitals = $hospitals->map(function ($hospital) {
                $hospitalArray = $hospital->toArray();
                $serviceOffers = $hospital->hospitalRequests->where('status', 'active')->pluck('service_offer');
                unset($hospitalArray['hospital_requests']);
                $hospitalArray['service_offers'] = $serviceOffers;
                return $hospitalArray;
            });
            return response()->json($formattedHospitals, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function getServiceOffersForHospital($hospitalId)
    {
        try {
            $hospital = Hospital::with('hospitalRequests')->findOrFail($hospitalId);
            $serviceOffers = $hospital->hospitalRequests->map(function ($request) {
                return [
                    'id' => $request->id,
                    'service_offer' => $request->service_offer,
                    'status' => $request->status
                ];
            });

            return response()->json(['success' => true, 'service_offers' => $serviceOffers], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Hospital or service offers not found.'], 404);
        }
    }
    public function delete_offer(string $id)
    {
        try {
            $hospital = HospitalRequest::findOrFail($id);
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
    public function active_offer(string $id)
    {
        try {
            DB::beginTransaction();
            $Hospital = HospitalRequest::findOrFail($id);
            $Hospital->status = 'active';
            $Hospital->save();
            DB::commit();
            return response()->json(['message' => 'Hospital updated successfully'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function deactivate_offer(string $id)
    {
        try {
            DB::beginTransaction();
            $Hospital = HospitalRequest::findOrFail($id);
            $Hospital->status = 'inactive';
            $Hospital->save();
            DB::commit();
            return response()->json(['message' => 'Hospital updated successfully'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
