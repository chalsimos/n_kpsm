<?php

namespace App\Http\Controllers;

use App\Mail\EducationalAssistanceApproved;
use App\Mail\EducationalAssistanceCustomEmail;
use App\Mail\EducationalAssistanceDecline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\EducationalAssistance;
use App\Models\EducationalAssistanceAmount;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use App\Mail\EducationalAssistanceMail;
use Exception;
use Illuminate\Support\Facades\Log;

class EducationalAssistanceController extends Controller
{
    public function get_all_approved_scholarship_request(Request $request)
    {
        try {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $query = EducationalAssistance::where('status', 'approved')
                ->where('educational_assistance_type', 'educational_assistance');
            if ($startDate && $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            } else {
                $query->whereYear('created_at', date('Y'))
                    ->whereMonth('created_at', date('m'));
            }
            $educationalAssistances = $query->get();
            $educationalAssistanceAmounts = EducationalAssistanceAmount::where('status', 'active')->first();
            foreach ($educationalAssistances as $assistance) {
                $preprocessedSchoolLevel = str_replace(' ', '_', strtolower($assistance->school_level)) . '_amount';
                $amount = $educationalAssistanceAmounts->{$preprocessedSchoolLevel} ?? null;
                $assistance->amount = $amount;
            }
            return response()->json($educationalAssistances, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function get_all_decline_scholarship_request(Request $request)
    {
        try {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $query = EducationalAssistance::where('status', 'decline')
                ->where('educational_assistance_type', 'educational_assistance');
            if ($startDate && $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            } else {
                $query->whereYear('created_at', date('Y'))
                    ->whereMonth('created_at', date('m'));
            }
            $educationalAssistances = $query->get();
            $educationalAssistanceAmounts = EducationalAssistanceAmount::where('status', 'active')->first();
            foreach ($educationalAssistances as $assistance) {
                $preprocessedSchoolLevel = str_replace(' ', '_', strtolower($assistance->school_level)) . '_amount';
                $amount = $educationalAssistanceAmounts->{$preprocessedSchoolLevel} ?? null;
                $assistance->amount = $amount;
            }
            return response()->json($educationalAssistances, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function get_all_pending_scholarship_request(Request $request)
    {
        try {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $query = EducationalAssistance::where('status', 'pending')
                ->where('educational_assistance_type', 'educational_assistance');
            if ($startDate && $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            } else {
                $query->whereYear('created_at', date('Y'))
                    ->whereMonth('created_at', date('m'));
            }
            $educationalAssistances = $query->get();
            $educationalAssistanceAmounts = EducationalAssistanceAmount::where('status', 'active')->first();
            foreach ($educationalAssistances as $assistance) {
                $preprocessedSchoolLevel = str_replace(' ', '_', strtolower($assistance->school_level)) . '_amount';
                $amount = $educationalAssistanceAmounts->{$preprocessedSchoolLevel} ?? null;
                $assistance->amount = $amount;
            }
            return response()->json($educationalAssistances, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function get_all_approved_scholarship_request_tulong_dunong(Request $request)
    {
        try {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $query = EducationalAssistance::where('status', 'approved')
                ->where('educational_assistance_type', 'tulong_dunong');
            if ($startDate && $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            } else {
                $query->whereYear('created_at', date('Y'))
                    ->whereMonth('created_at', date('m'));
            }
            $educationalAssistances = $query->get();
            $educationalAssistanceAmounts = EducationalAssistanceAmount::where('status', 'active')->first();
            foreach ($educationalAssistances as $assistance) {
                $preprocessedSchoolLevel = str_replace(' ', '_', strtolower($assistance->school_level)) . '_amount';
                $amount = $educationalAssistanceAmounts->{$preprocessedSchoolLevel} ?? null;
                $assistance->amount = $amount;
            }
            return response()->json($educationalAssistances, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function get_all_decline_scholarship_request_tulong_dunong(Request $request)
    {
        try {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $query = EducationalAssistance::where('status', 'decline')
                ->where('educational_assistance_type', 'tulong_dunong');
            if ($startDate && $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            } else {
                $query->whereYear('created_at', date('Y'))
                    ->whereMonth('created_at', date('m'));
            }
            $educationalAssistances = $query->get();
            $educationalAssistanceAmounts = EducationalAssistanceAmount::where('status', 'active')->first();
            foreach ($educationalAssistances as $assistance) {
                $preprocessedSchoolLevel = str_replace(' ', '_', strtolower($assistance->school_level)) . '_amount';
                $amount = $educationalAssistanceAmounts->{$preprocessedSchoolLevel} ?? null;
                $assistance->amount = $amount;
            }
            return response()->json($educationalAssistances, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function get_all_pending_scholarship_request_tulong_dunong(Request $request)
    {
        try {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $query = EducationalAssistance::where('status', 'pending')
                ->where('educational_assistance_type', 'tulong_dunong');
            if ($startDate && $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            } else {
                $query->whereYear('created_at', date('Y'))
                    ->whereMonth('created_at', date('m'));
            }
            $educationalAssistances = $query->get();
            $educationalAssistanceAmounts = EducationalAssistanceAmount::where('status', 'active')->first();
            foreach ($educationalAssistances as $assistance) {
                $preprocessedSchoolLevel = str_replace(' ', '_', strtolower($assistance->school_level)) . '_amount';
                $amount = $educationalAssistanceAmounts->{$preprocessedSchoolLevel} ?? null;
                $assistance->amount = $amount;
            }
            return response()->json($educationalAssistances, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function get_all_approved_scholarship_request_smart_grant(Request $request)
    {
        try {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $query = EducationalAssistance::where('status', 'approved')
                ->where('educational_assistance_type', 'smart_grant');
            if ($startDate && $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            } else {
                $query->whereYear('created_at', date('Y'))
                    ->whereMonth('created_at', date('m'));
            }
            $educationalAssistances = $query->get();
            $educationalAssistanceAmounts = EducationalAssistanceAmount::where('status', 'active')->first();
            foreach ($educationalAssistances as $assistance) {
                $preprocessedSchoolLevel = str_replace(' ', '_', strtolower($assistance->school_level)) . '_amount';
                $amount = $educationalAssistanceAmounts->{$preprocessedSchoolLevel} ?? null;
                $assistance->amount = $amount;
            }
            return response()->json($educationalAssistances, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function get_all_decline_scholarship_request_smart_grant(Request $request)
    {
        try {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $query = EducationalAssistance::where('status', 'decline')
                ->where('educational_assistance_type', 'smart_grant');
            if ($startDate && $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            } else {
                $query->whereYear('created_at', date('Y'))
                    ->whereMonth('created_at', date('m'));
            }
            $educationalAssistances = $query->get();
            $educationalAssistanceAmounts = EducationalAssistanceAmount::where('status', 'active')->first();
            foreach ($educationalAssistances as $assistance) {
                $preprocessedSchoolLevel = str_replace(' ', '_', strtolower($assistance->school_level)) . '_amount';
                $amount = $educationalAssistanceAmounts->{$preprocessedSchoolLevel} ?? null;
                $assistance->amount = $amount;
            }
            return response()->json($educationalAssistances, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function get_all_pending_scholarship_request_smart_grant(Request $request)
    {
        try {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $query = EducationalAssistance::where('status', 'pending')
                ->where('educational_assistance_type', 'smart_grant');
            if ($startDate && $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            } else {
                $query->whereYear('created_at', date('Y'))
                    ->whereMonth('created_at', date('m'));
            }
            $educationalAssistances = $query->get();
            $educationalAssistanceAmounts = EducationalAssistanceAmount::where('status', 'active')->first();
            foreach ($educationalAssistances as $assistance) {
                $preprocessedSchoolLevel = str_replace(' ', '_', strtolower($assistance->school_level)) . '_amount';
                $amount = $educationalAssistanceAmounts->{$preprocessedSchoolLevel} ?? null;
                $assistance->amount = $amount;
            }
            return response()->json($educationalAssistances, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function decline_educational_assistance(Request $request, $id)
    {
        try {
            $educationalRequest = EducationalAssistance::findOrFail($id);
            $validatedData = $request->validate([
                'decline_reason' => 'required',
            ]);
            $educationalRequest->decline_reason = $validatedData['decline_reason'];
            $educationalRequest->status = 'declined';
            if ($educationalRequest->save()) {
                $studentEmail = $educationalRequest->student_email;
                $studentName = $educationalRequest->beneficiary_lastname;
                $info = [
                    'firstname' => $studentName,
                    'decline' => $validatedData['decline_reason'],
                ];
                Mail::to($studentEmail)->send(new EducationalAssistanceDecline($info['firstname'], $info['decline']));
                return response()->json($educationalRequest, 200);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function send_email_to_student(Request $request, $id)
    {
        try {
            $educationalRequest = EducationalAssistance::findOrFail($id);
            $studentEmail = $educationalRequest->student_email;
            $studentname = $educationalRequest->beneficiary_lastname;
            $subject = $request->input('subject');
            $emailmessage = $request->input('message');

            $info = [
                'firstname' => $studentname,
                'subject' => $subject,
                'emailmessage' => $emailmessage
            ];

            Mail::to($studentEmail)->send(new EducationalAssistanceCustomEmail($info['firstname'], $info['subject'], $info['emailmessage']));

            return response()->json(['data' => 'Email sent successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    public function accept_educational_assistance(Request $request, $id)
    {
        try {
            $educationalRequest = EducationalAssistance::findOrFail($id);
            $validatedData = $request->validate([
                'amount' => 'required|numeric',
            ]);
            $educationalRequest->status = 'approved';
            $amount = $validatedData['amount'];
            if ($educationalRequest->save()) {
                $studentEmail = $educationalRequest->student_email;
                $studentname = $educationalRequest->beneficiary_lastname;
                $info = [
                    'firstname' => $studentname,
                    'amount' => $amount,
                ];
                Mail::to($studentEmail)->send(new EducationalAssistanceApproved($info['firstname'], $info['amount']));
                return response()->json(['data' => $educationalRequest], 200);
            } else {
                return response()->json(['error' => 'Failed to update status'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    public function check_educational_assistance_application_status(Request $request)
    {
        try {
            $validator = validator()->make($request->all(), [
                'code' => 'required|string',
            ]);
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }
            $code = $request->input('code');
            $application = EducationalAssistance::where('code', $code)->first();
            if (!$application) {
                return response()->json(['error' => 'Application not found.'], 404);
            }
            return response()->json(['status' => $application->status], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function apply_educational_assistance_tulong_dunong(Request $request)
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
            'email' => 'required|string|email|unique:users,email',
            'brgy_IndigencyImages.*' => 'image',
            'valid_IdImages.*' => 'image',
            'certificate_of_enrollment_images.*' => 'image',
            'certificate_of_registration_images.*' => 'image',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        try {
            DB::beginTransaction();
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $codeGenerated = $request->input('beneficiary_lastname') . '_' . str_shuffle(substr(str_shuffle($characters), 0, 10));
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
            $data->student_email = $request->input('email');
            $data->code = $codeGenerated;
            $data->status = 'pending';
            $data->educational_assistance_type = 'tulong_dunong';
            $data->save();
            $basePath = 'Request/Tulong Dunong/' . now()->year . '/' . now()->format('F') . '/';
            $directoryPath = $basePath . $request->input('municipality') . '/' . $request->input('barangay') . '/' . $request->input('school') . '/' . $request->input('year_level') . '/' . $data->beneficiary_lastname . ' ' . $data->beneficiary_middlename . ' ' . $data->beneficiary_firstname . '/' . now()->year . ' ' . now()->format('F') . ' ' . now()->format('d') . '/';
            if (!Storage::exists('public/' . $directoryPath)) {
                Storage::makeDirectory('public/' . $directoryPath);
            }
            $brgyIndigencyImagePaths = [];
            $validIdImagePaths = [];
            $registrationimagepath = [];
            $enrollmentimagepath = [];
            if ($request->hasFile('brgy_IndigencyImages')) {
                foreach ($request->file('brgy_IndigencyImages') as $image) {
                    $imageName = 'brgy_Indigency_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $imagePath = $directoryPath . $imageName;
                    Log::info('Moving file: ' . $imagePath);
                    Storage::putFileAs('public/' . $directoryPath, $image, $imageName);
                    $brgyIndigencyImagePaths[] = $imagePath;
                }
            }
            if ($request->hasFile('valid_IdImages')) {
                foreach ($request->file('valid_IdImages') as $image) {
                    $imageName = 'valid_id_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $imagePath = $directoryPath . $imageName;
                    Log::info('Moving file: ' . $imagePath);
                    Storage::putFileAs('public/' . $directoryPath, $image, $imageName);
                    $validIdImagePaths[] = $imagePath;
                }
            }
            if ($request->hasFile('certificate_of_registration_images')) {
                foreach ($request->file('certificate_of_registration_images') as $image) {
                    $imageName = 'certificate_of_registration' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $imagePath = $directoryPath . $imageName;
                    Log::info('Moving file: ' . $imagePath);
                    Storage::putFileAs('public/' . $directoryPath, $image, $imageName);
                    $registrationimagepath[] = $imagePath;
                }
            }
            if ($request->hasFile('certificate_of_enrollment_images')) {
                foreach ($request->file('certificate_of_enrollment_images') as $image) {
                    $imageName = 'certificate_of_enrollment' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $imagePath = $directoryPath . $imageName;
                    Log::info('Moving file: ' . $imagePath);
                    Storage::putFileAs('public/' . $directoryPath, $image, $imageName);
                    $enrollmentimagepath[] = $imagePath;
                }
            }
            $data->update([
                'barangay_indigency_imagepath' => implode(',', $brgyIndigencyImagePaths),
                'valid_id_imagepath' => implode(',', $validIdImagePaths),
                'certificate_of_enrollment_imagepath' => implode(',', $enrollmentimagepath),
                'certificate_of_registration_imagepath' => implode(',', $registrationimagepath),
            ]);
            $url = url('http://localhost:9000/educational-assistance');
            $info = [
                'firstname' => $request->input('beneficiary_firstname'),
                'codeGenerated' => $codeGenerated,
                'url' => $url,
            ];
            Mail::to($request->input('email'))->send(new EducationalAssistanceMail($info['firstname'], $info['codeGenerated'], $info['url']));

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function apply_educational_assistance_smart_grant(Request $request)
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
            'email' => 'required|string|email|unique:users,email',
            'brgy_IndigencyImages.*' => 'image',
            'valid_IdImages.*' => 'image',
            'certificate_of_enrollment_images.*' => 'image',
            'certificate_of_registration_images.*' => 'image',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        try {
            DB::beginTransaction();
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $codeGenerated = $request->input('beneficiary_lastname') . '_' . str_shuffle(substr(str_shuffle($characters), 0, 10));
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
            $data->student_email = $request->input('email');
            $data->code = $codeGenerated;
            $data->status = 'pending';
            $data->educational_assistance_type = 'smart_grant';
            $data->save();
            $basePath = 'Request/Smart Grant/' . now()->year . '/' . now()->format('F') . '/';
            $directoryPath = $basePath . $request->input('municipality') . '/' . $request->input('barangay') . '/' . $request->input('school') . '/' . $request->input('year_level') . '/' . $data->beneficiary_lastname . ' ' . $data->beneficiary_middlename . ' ' . $data->beneficiary_firstname . '/' . now()->year . ' ' . now()->format('F') . ' ' . now()->format('d') . '/';
            if (!Storage::exists('public/' . $directoryPath)) {
                Storage::makeDirectory('public/' . $directoryPath);
            }
            $brgyIndigencyImagePaths = [];
            $validIdImagePaths = [];
            $registrationimagepath = [];
            $enrollmentimagepath = [];
            if ($request->hasFile('brgy_IndigencyImages')) {
                foreach ($request->file('brgy_IndigencyImages') as $image) {
                    $imageName = 'brgy_Indigency_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $imagePath = $directoryPath . $imageName;
                    Log::info('Moving file: ' . $imagePath);
                    Storage::putFileAs('public/' . $directoryPath, $image, $imageName);
                    $brgyIndigencyImagePaths[] = $imagePath;
                }
            }
            if ($request->hasFile('valid_IdImages')) {
                foreach ($request->file('valid_IdImages') as $image) {
                    $imageName = 'valid_id_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $imagePath = $directoryPath . $imageName;
                    Log::info('Moving file: ' . $imagePath);
                    Storage::putFileAs('public/' . $directoryPath, $image, $imageName);
                    $validIdImagePaths[] = $imagePath;
                }
            }
            if ($request->hasFile('certificate_of_registration_images')) {
                foreach ($request->file('certificate_of_registration_images') as $image) {
                    $imageName = 'certificate_of_registration' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $imagePath = $directoryPath . $imageName;
                    Log::info('Moving file: ' . $imagePath);
                    Storage::putFileAs('public/' . $directoryPath, $image, $imageName);
                    $registrationimagepath[] = $imagePath;
                }
            }
            if ($request->hasFile('certificate_of_enrollment_images')) {
                foreach ($request->file('certificate_of_enrollment_images') as $image) {
                    $imageName = 'certificate_of_enrollment' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $imagePath = $directoryPath . $imageName;
                    Log::info('Moving file: ' . $imagePath);
                    Storage::putFileAs('public/' . $directoryPath, $image, $imageName);
                    $enrollmentimagepath[] = $imagePath;
                }
            }
            $data->update([
                'barangay_indigency_imagepath' => implode(',', $brgyIndigencyImagePaths),
                'valid_id_imagepath' => implode(',', $validIdImagePaths),
                'certificate_of_enrollment_imagepath' => implode(',', $enrollmentimagepath),
                'certificate_of_registration_imagepath' => implode(',', $registrationimagepath),
            ]);
            $url = url('http://localhost:9000/educational-assistance');
            $info = [
                'firstname' => $request->input('beneficiary_firstname'),
                'codeGenerated' => $codeGenerated,
                'url' => $url,
            ];
            Mail::to($request->input('email'))->send(new EducationalAssistanceMail($info['firstname'], $info['codeGenerated'], $info['url']));

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function requirementsPath(Request $request, $id)
    {
        try {
            $educationalrequest = EducationalAssistance::findOrFail($id);
            $requestData = $educationalrequest->toArray();
            $imageUrls = [
                'barangay_indigency_imagepath' => [],
                'valid_id_imagepath' => [],
                'certificate_of_enrollment_imagepath' => [],
                'certificate_of_registration_imagepath' => [],
            ];
            foreach ($imageUrls as $key => $imagePaths) {
                $imagePaths = explode(',', $requestData[$key]);
                foreach ($imagePaths as $imagePath) {
                    $imageUrl = Storage::url($imagePath);
                    $imageUrls[$key][] = $imageUrl;
                }
            }
            $responseData = array_merge($requestData, $imageUrls);
            return response()->json($responseData);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
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
            'email' => 'required|string|email|unique:users,email',
            'brgy_IndigencyImages.*' => 'image',
            'valid_IdImages.*' => 'image',
            'certificate_of_enrollment_images.*' => 'image',
            'certificate_of_registration_images.*' => 'image',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        try {
            DB::beginTransaction();
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $codeGenerated = $request->input('beneficiary_lastname') . '_' . str_shuffle(substr(str_shuffle($characters), 0, 10));
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
            $data->student_email = $request->input('email');
            $data->code = $codeGenerated;
            $data->status = 'pending';
            $data->educational_assistance_type = 'educational_assistance';
            $data->save();
            $basePath = 'Request/Educational Request/' . now()->year . '/' . now()->format('F') . '/';
            $directoryPath = $basePath . $request->input('municipality') . '/' . $request->input('barangay') . '/' . $request->input('school') . '/' . $request->input('year_level') . '/' . $data->beneficiary_lastname . ' ' . $data->beneficiary_middlename . ' ' . $data->beneficiary_firstname . '/' . now()->year . ' ' . now()->format('F') . ' ' . now()->format('d') . '/';
            if (!Storage::exists('public/' . $directoryPath)) {
                Storage::makeDirectory('public/' . $directoryPath);
            }
            $brgyIndigencyImagePaths = [];
            $validIdImagePaths = [];
            $registrationimagepath = [];
            $enrollmentimagepath = [];
            if ($request->hasFile('brgy_IndigencyImages')) {
                foreach ($request->file('brgy_IndigencyImages') as $image) {
                    $imageName = 'brgy_Indigency_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $imagePath = $directoryPath . $imageName;
                    Log::info('Moving file: ' . $imagePath);
                    Storage::putFileAs('public/' . $directoryPath, $image, $imageName);
                    $brgyIndigencyImagePaths[] = $imagePath;
                }
            }
            if ($request->hasFile('valid_IdImages')) {
                foreach ($request->file('valid_IdImages') as $image) {
                    $imageName = 'valid_id_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $imagePath = $directoryPath . $imageName;
                    Log::info('Moving file: ' . $imagePath);
                    Storage::putFileAs('public/' . $directoryPath, $image, $imageName);
                    $validIdImagePaths[] = $imagePath;
                }
            }
            if ($request->hasFile('certificate_of_registration_images')) {
                foreach ($request->file('certificate_of_registration_images') as $image) {
                    $imageName = 'certificate_of_registration' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $imagePath = $directoryPath . $imageName;
                    Log::info('Moving file: ' . $imagePath);
                    Storage::putFileAs('public/' . $directoryPath, $image, $imageName);
                    $registrationimagepath[] = $imagePath;
                }
            }
            if ($request->hasFile('certificate_of_enrollment_images')) {
                foreach ($request->file('certificate_of_enrollment_images') as $image) {
                    $imageName = 'certificate_of_enrollment' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $imagePath = $directoryPath . $imageName;
                    Log::info('Moving file: ' . $imagePath);
                    Storage::putFileAs('public/' . $directoryPath, $image, $imageName);
                    $enrollmentimagepath[] = $imagePath;
                }
            }
            $data->update([
                'barangay_indigency_imagepath' => implode(',', $brgyIndigencyImagePaths),
                'valid_id_imagepath' => implode(',', $validIdImagePaths),
                'certificate_of_enrollment_imagepath' => implode(',', $enrollmentimagepath),
                'certificate_of_registration_imagepath' => implode(',', $registrationimagepath),
            ]);
            $url = url('http://localhost:9000/educational-assistance');
            $info = [
                'firstname' => $request->input('beneficiary_firstname'),
                'codeGenerated' => $codeGenerated,
                'url' => $url,
            ];
            Mail::to($request->input('email'))->send(new EducationalAssistanceMail($info['firstname'], $info['codeGenerated'], $info['url']));
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function add_educational_assistance_amount(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'elementary_amount' => 'required|integer',
            'high_school_amount' => 'required|integer',
            'senior_high_school_amount' => 'required|integer',
            'vocational_amount' => 'required|integer',
            'college_amount' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        try {
            DB::beginTransaction();
            EducationalAssistanceAmount::where('status', 'active')->update(['status' => 'inactive']);
            $data = new EducationalAssistanceAmount();
            $data->elementary_amount = $request->input('elementary_amount');
            $data->high_school_amount = $request->input('high_school_amount');
            $data->senior_high_school_amount = $request->input('senior_high_school_amount');
            $data->college_amount = $request->input('college_amount');
            $data->vocational_amount = $request->input('vocational_amount');
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
            'elementary_amount' => 'nullable|integer',
            'high_school_amount' => 'nullable|integer',
            'senior_high_school_amount' => 'nullable|integer',
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
            $data->elementary_amount = $request->input('elementary_amount', $data->elementary_amount);
            $data->high_school_amount = $request->input('highschool_amount', $data->highschool_amount);
            $data->senior_high_school_amount = $request->input('senior_high_school_amount', $data->senior_high_school_amount);
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
    public function index(Request $request)
    {
        try {
            $amount = EducationalAssistanceAmount::all();

            return response()->json($amount, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function deleteAmount(Request $request, $id)
    {
        try {
            $Amount = EducationalAssistanceAmount::findOrFail($id);
            if ($Amount->status === 'active') {
                return response()->json(['error' => 'Cannot delete active Amount'], 400);
            }
            $Amount->delete();
            return response()->json(['message' => 'Amount deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
