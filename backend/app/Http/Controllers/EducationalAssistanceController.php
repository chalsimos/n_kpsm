<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\EducationalAssistance;
use App\Models\EducationalAssistanceAmount;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class EducationalAssistanceController extends Controller
{
    public function apply_educational_assistance(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'representative_lastname' => 'nullable|string|max:255',
            'representative_firstname' => 'nullable|string|max:255',
            'representative_middlename' => 'nullable|string|max:255',
            'representative_birthday' => 'nullable|date',
            'representative_gender' => 'nullable|string|in:Male,Female',
            'representative_age' => 'nullable|integer|min:0',
            'beneficiary_lastname' => 'nullable|string|max:255',
            'beneficiary_firstname' => 'nullable|string|max:255',
            'beneficiary_middlename' => 'nullable|string|max:255',
            'beneficiary_birthday' => 'nullable|date',
            'beneficiary_age' => 'nullable|integer|min:0',
            'beneficiary_gender' => 'nullable|string|in:Male,Female',
            'relationship_to_beneficiary' => 'nullable|string|max:255',
            'contact_number' => 'nullable|max:11',
            'province' => 'nullable|string|max:255',
            'municipality' => 'nullable|string|max:255',
            'barangay' => 'nullable|string|max:255',
            'sitio' => 'nullable|string|max:255',
            'school' => 'nullable|string|max:255',
            'school_level' => 'nullable|string|max:255',
            'year_level' => 'nullable|string|max:255',
            'academic_year_stage' => 'nullable|string|max:255',
            'remarks' => 'nullable|string|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        try {
            DB::beginTransaction();
            $data = new EducationalAssistance();
            $data->representative_lastname = $request->input('representative_lastname');
            $data->representative_firstname = $request->input('representative_firstname');
            $data->representative_middlename = $request->input('representative_middlename');
            $data->representative_birthday = $request->input('representative_birthday');
            $data->representative_gender = $request->input('representative_gender');
            $data->representative_age = $request->input('representative_age');
            $data->beneficiary_lastname = $request->input('beneficiary_lastname');
            $data->beneficiary_firstname = $request->input('beneficiary_firstname');
            $data->beneficiary_middlename = $request->input('beneficiary_middlename');
            $data->beneficiary_birthday = $request->input('beneficiary_birthday');
            $data->beneficiary_age = $request->input('beneficiary_age');
            $data->beneficiary_gender = $request->input('beneficiary_gender');
            $data->relationship_to_beneficiary = $request->input('relationship_to_beneficiary');
            $data->contact_number = $request->input('contact_number');
            $data->province = $request->input('province');
            $data->municipality = $request->input('municipality');
            $data->barangay = $request->input('barangay');
            $data->sitio = $request->input('sitio');
            $data->school = $request->input('school');
            $data->school_level = $request->input('school_level');
            $data->year_level = $request->input('year_level');
            $data->academic_year_stage = $request->input('academic_year_stage');
            $data->remarks = $request->input('remarks');
            $data->status = 'pending';
            $data->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function educational_assistance_amount(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'elemantary_amount' => 'nullable|integer',
            'highschool_amount' => 'nullable|integer',
            'senior_highschool_amount' => 'nullable|integer',
            'vocational_college_amount' => 'nullable|integer',
            'total_target' => 'nullable|integer',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        try {
            DB::beginTransaction();
            EducationalAssistanceAmount::where('status', 'active')->update(['status' => 'inactive']);
            $data = new EducationalAssistanceAmount();
            $data->elemantary_amount = $request->input('elemantary_amount');
            $data->highschool_amount = $request->input('highschool_amount');
            $data->senior_highschool_amount = $request->input('senior_highschool_amount');
            $data->vocational_college_amount = $request->input('vocational_college_amount');
            $data->total_target = $request->input('total_target');
            $data->status = 'active';
            $data->save();
            DB::commit();
            return response()->json(['message' => 'Educational assistance amount created successfully'], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function educational_assistance_amount_update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'elemantary_amount' => 'nullable|integer',
            'highschool_amount' => 'nullable|integer',
            'senior_highschool_amount' => 'nullable|integer',
            'vocational_college_amount' => 'nullable|integer',
            'total_target' => 'nullable|integer',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        try {
            DB::beginTransaction();
            $data = EducationalAssistanceAmount::find($id);
            if (!$data) {
                return response()->json(['error' => 'Educational assistance amount not found'], 404);
            }
            $data->elemantary_amount = $request->input('elemantary_amount', $data->elemantary_amount);
            $data->highschool_amount = $request->input('highschool_amount', $data->highschool_amount);
            $data->senior_highschool_amount = $request->input('senior_highschool_amount', $data->senior_highschool_amount);
            $data->vocational_college_amount = $request->input('vocational_college_amount', $data->vocational_college_amount);
            $data->total_target = $request->input('total_target', $data->total_target);
            $data->save();
            DB::commit();
            return response()->json(['message' => 'Educational assistance amount updated successfully'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function educational_assistance_amount_change_status(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $requestedItem = EducationalAssistanceAmount::find($id);
            if (!$requestedItem) {
                return response()->json(['error' => 'Educational assistance amount not found'], 404);
            }
            if ($requestedItem->status === 'active') {
                return response()->json(['message' => 'Status is already active'], 200);
            }
            EducationalAssistanceAmount::where('id', '!=', $id)
                ->update(['status' => 'inactive']);
            $requestedItem->status = 'active';
            $requestedItem->save();
            DB::commit();
            return response()->json(['message' => 'Status updated successfully'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
