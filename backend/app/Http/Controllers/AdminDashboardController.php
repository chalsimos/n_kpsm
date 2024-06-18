<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Hospital;
use App\Models\HospitalRequest;
use App\Models\EducationalAssistance;
use App\Models\Tupad;
use App\Models\TupadCode;
use App\Models\TupadSlot;
use App\Models\MedicalRequest;
use App\Models\TupadExcelHeader;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AdminDashboardController extends Controller
{
    public function getEducationalRequestsData()
    {
        $data = DB::transaction(function () {
            $yearsData = EducationalAssistance::select(DB::raw('YEAR(created_at) as year'), DB::raw('COUNT(*) as total_per_year'))
                ->groupBy('year')
                ->get()
                ->map(function ($yearData) {
                    $year = $yearData->year;
                    $totalPerYear = $yearData->total_per_year;
                    $monthsData = EducationalAssistance::whereYear('created_at', $year)
                        ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as total_per_month'))
                        ->groupBy('month')
                        ->get()
                        ->map(function ($monthData) use ($year) {
                            $month = $monthData->month;
                            $totalPerMonth = $monthData->total_per_month;
                            $monthName = Carbon::create()->month($month)->format('F');
                            $schoolData = EducationalAssistance::whereYear('created_at', $year)
                                ->whereMonth('created_at', $month)
                                ->groupBy('school')
                                ->select('school', DB::raw('COUNT(*) as total_per_school'))
                                ->get()
                                ->map(function ($schoolData) use ($year, $month) {
                                    $school = $schoolData->school;
                                    $totalPerschool = $schoolData->total_per_school;
                                    $municipalitiesData = EducationalAssistance::whereYear('created_at', $year)
                                        ->whereMonth('created_at', $month)
                                        ->where('school', $school)
                                        ->groupBy('municipality')
                                        ->select('municipality', DB::raw('COUNT(*) as total_per_municipality'))
                                        ->get()
                                        ->map(function ($municipalityData) use ($year, $month, $school) {
                                            $municipality = $municipalityData->municipality;
                                            $totalPerMunicipality = $municipalityData->total_per_municipality;
                                            $barangaysData = EducationalAssistance::whereYear('created_at', $year)
                                                ->whereMonth('created_at', $month)
                                                ->where('school', $school)
                                                ->where('municipality', $municipality)
                                                ->groupBy('barangay')
                                                ->select('barangay', DB::raw('COUNT(*) as total_per_barangay'))
                                                ->get()
                                                ->map(function ($barangayData) use ($year, $month, $school, $municipality) {
                                                    $barangay = $barangayData->barangay;
                                                    $totalPerBarangay = $barangayData->total_per_barangay;
                                                    $details = EducationalAssistance::whereYear('created_at', $year)
                                                        ->whereMonth('created_at', $month)
                                                        ->where('school', $school)
                                                        ->where('municipality', $municipality)
                                                        ->where('barangay', $barangay)
                                                        ->select(
                                                            'representative_lastname',
                                                            'representative_firstname',
                                                            'representative_middlename',
                                                            'representative_age',
                                                            'representative_birthday',
                                                            'representative_gender',
                                                            'beneficiary_lastname',
                                                            'beneficiary_firstname',
                                                            'beneficiary_middlename',
                                                            'beneficiary_age',
                                                            'beneficiary_birthday',
                                                            'beneficiary_gender',
                                                            'relationship_to_beneficiary',
                                                            'contact_number',
                                                            'school_level',
                                                            'year_level',
                                                            'academic_year_stage',
                                                        )
                                                        ->get()
                                                        ->map(function ($detail) {
                                                            return [
                                                                'representative_lastname' => $detail->representative_lastname,
                                                                'representative_firstname' => $detail->representative_firstname,
                                                                'representative_middlename' => $detail->representative_middlename,
                                                                'representative_age' => $detail->representative_age,
                                                                'representative_birthday' => $detail->representative_birthday,
                                                                'representative_gender' => $detail->representative_gender,
                                                                'beneficiary_lastname' => $detail->beneficiary_lastname,
                                                                'beneficiary_firstname' => $detail->beneficiary_firstname,
                                                                'beneficiary_middlename' => $detail->beneficiary_middlename,
                                                                'beneficiary_age' => $detail->beneficiary_age,
                                                                'beneficiary_birthday' => $detail->beneficiary_birthday,
                                                                'beneficiary_gender' => $detail->beneficiary_gender,
                                                                'relationship_to_beneficiary' => $detail->relationship_to_beneficiary,
                                                                'contact_number' => $detail->contact_number,
                                                                'school_level' => $detail->school_level,
                                                                'year_level' => $detail->year_level,
                                                                'academic_year_stage' => $detail->academic_year_stage,
                                                            ];
                                                        })
                                                        ->values();
                                                    return [
                                                        'barangay' => $barangay,
                                                        'total_per_barangay' => $totalPerBarangay,
                                                        'details' => $details,
                                                    ];
                                                })
                                                ->values();
                                            return [
                                                'municipality' => $municipality,
                                                'total_per_municipality' => $totalPerMunicipality,
                                                'barangays' => $barangaysData,
                                            ];
                                        })
                                        ->values();
                                    return [
                                        'school' => $school,
                                        'total_per_school' => $totalPerschool,
                                        'municipalities' => $municipalitiesData,
                                    ];
                                })
                                ->values();
                            return [
                                'month' => $monthName,
                                'total_per_month' => $totalPerMonth,
                                'school' => $schoolData,
                            ];
                        })
                        ->values();
                    return [
                        'year' => $year,
                        'total_per_year' => $totalPerYear,
                        'months' => $monthsData,
                    ];
                })
                ->values();
            return $yearsData;
        });
        return response()->json($data);
    }

    public function getMedicalRequestsData()
    {
        $data = DB::transaction(function () {
            $yearsData = MedicalRequest::select(DB::raw('YEAR(created_at) as year'), DB::raw('COUNT(*) as total_per_year'))
                ->groupBy('year')
                ->get()
                ->map(function ($yearData) {
                    $year = $yearData->year;
                    $totalPerYear = $yearData->total_per_year;
                    $monthsData = MedicalRequest::whereYear('created_at', $year)
                        ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as total_per_month'))
                        ->groupBy('month')
                        ->get()
                        ->map(function ($monthData) use ($year) {
                            $month = $monthData->month;
                            $totalPerMonth = $monthData->total_per_month;
                            $monthName = Carbon::create()->month($month)->format('F');
                            $hospitalsData = MedicalRequest::whereYear('created_at', $year)
                                ->whereMonth('created_at', $month)
                                ->groupBy('hospital')
                                ->select('hospital', DB::raw('COUNT(*) as total_per_hospital'))
                                ->get()
                                ->map(function ($hospitalData) use ($year, $month) {
                                    $hospital = $hospitalData->hospital;
                                    $totalPerHospital = $hospitalData->total_per_hospital;
                                    $municipalitiesData = MedicalRequest::whereYear('created_at', $year)
                                        ->whereMonth('created_at', $month)
                                        ->where('hospital', $hospital)
                                        ->groupBy('municipality')
                                        ->select('municipality', DB::raw('COUNT(*) as total_per_municipality'))
                                        ->get()
                                        ->map(function ($municipalityData) use ($year, $month, $hospital) {
                                            $municipality = $municipalityData->municipality;
                                            $totalPerMunicipality = $municipalityData->total_per_municipality;
                                            $barangaysData = MedicalRequest::whereYear('created_at', $year)
                                                ->whereMonth('created_at', $month)
                                                ->where('hospital', $hospital)
                                                ->where('municipality', $municipality)
                                                ->groupBy('barangay')
                                                ->select('barangay', DB::raw('COUNT(*) as total_per_barangay'))
                                                ->get()
                                                ->map(function ($barangayData) use ($year, $month, $hospital, $municipality) {
                                                    $barangay = $barangayData->barangay;
                                                    $totalPerBarangay = $barangayData->total_per_barangay;
                                                    $details = MedicalRequest::whereYear('created_at', $year)
                                                        ->whereMonth('created_at', $month)
                                                        ->where('hospital', $hospital)
                                                        ->where('municipality', $municipality)
                                                        ->where('barangay', $barangay)
                                                        ->select(
                                                            'Hor_code',
                                                            'firstname',
                                                            'middlename',
                                                            'lastname',
                                                            'age',
                                                            'birthday',
                                                            'gender',
                                                            // 'province',
                                                            // 'municipality',
                                                            // 'barangay',
                                                            'representativefullname',
                                                            'contactnumber',
                                                            'diagnosis',
                                                            'hospital',
                                                            'request',
                                                            // 'status',
                                                            // 'amount'
                                                        )
                                                        ->get()
                                                        ->map(function ($detail) {
                                                            return [
                                                                'Hor_code' => $detail->Hor_code,
                                                                'firstname' => $detail->firstname,
                                                                'middlename' => $detail->middlename,
                                                                'lastname' => $detail->lastname,
                                                                'age' => $detail->age,
                                                                'birthday' => $detail->birthday,
                                                                'gender' => $detail->gender,
                                                                'province' => $detail->province,
                                                                'municipality' => $detail->municipality,
                                                                'barangay' => $detail->barangay,
                                                                'representativefullname' => $detail->representativefullname,
                                                                'contactnumber' => $detail->contactnumber,
                                                                'diagnosis' => $detail->diagnosis,
                                                                'hospital' => $detail->hospital,
                                                                'request' => $detail->request,
                                                                'status' => $detail->status,
                                                                'amount' => $detail->amount,
                                                            ];
                                                        })
                                                        ->values();
                                                    return [
                                                        'barangay' => $barangay,
                                                        'total_per_barangay' => $totalPerBarangay,
                                                        'details' => $details,
                                                    ];
                                                })
                                                ->values();
                                            return [
                                                'municipality' => $municipality,
                                                'total_per_municipality' => $totalPerMunicipality,
                                                'barangays' => $barangaysData,
                                            ];
                                        })
                                        ->values();
                                    return [
                                        'hospital' => $hospital,
                                        'total_per_hospital' => $totalPerHospital,
                                        'municipalities' => $municipalitiesData,
                                    ];
                                })
                                ->values();
                            return [
                                'month' => $monthName,
                                'total_per_month' => $totalPerMonth,
                                'hospitals' => $hospitalsData,
                            ];
                        })
                        ->values();
                    return [
                        'year' => $year,
                        'total_per_year' => $totalPerYear,
                        'months' => $monthsData,
                    ];
                })
                ->values();
            return $yearsData;
        });
        return response()->json($data);
    }
    public function getData()
    {
        $data = DB::transaction(function () {
            $yearsData = Tupad::select(DB::raw('YEAR(created_at) as year'), DB::raw('COUNT(*) as total_per_year'))
                ->groupBy('year')
                ->get()
                ->map(function ($yearData) {
                    $year = $yearData->year;
                    $totalPerYear = $yearData->total_per_year;
                    $monthsData = Tupad::whereYear('created_at', $year)
                        ->get()
                        ->groupBy(function ($item) {
                            return Carbon::parse($item->month_year_available)->format('F');
                        })
                        ->map(function ($items, $month) {
                            $totalPerMonth = $items->count();
                            $municipalitiesData = $items->groupBy('municipality')
                                ->map(function ($municipalityItems, $municipality) {
                                    $totalPerMunicipality = $municipalityItems->count();
                                    $barangaysData = $municipalityItems->groupBy('barangay')
                                        ->map(function ($barangayItems, $barangay) {
                                            return [
                                                'barangay' => $barangay,
                                                'total_per_barangay' => $barangayItems->count(),
                                                'details' => $barangayItems->map(function ($item) {
                                                    $fillableKeys = TupadExcelHeader::where('status', 'active')->pluck('key')->toArray();
                                                    $details = [];
                                                    foreach ($fillableKeys as $key) {
                                                        $details[$key] = $item->{$key};
                                                    }
                                                    $details['given_by_captain'] = User::find($item->given_by_captainID)->username;
                                                    return $details;
                                                })
                                            ];
                                        })
                                        ->values();
                                    return [
                                        'municipality' => $municipality,
                                        'total_per_municipality' => $totalPerMunicipality,
                                        'barangays' => $barangaysData,
                                    ];
                                })
                                ->values();
                            return [
                                'month' => $month,
                                'total_per_month' => $totalPerMonth,
                                'municipalities' => $municipalitiesData,
                            ];
                        })
                        ->values();
                    return [
                        'year' => $year,
                        'total_per_year' => $totalPerYear,
                        'months' => $monthsData,
                    ];
                })
                ->values();
            return $yearsData;
        });
        return response()->json($data);
    }

    public function getMunicipalityBarangayEducationalData(Request $request)
    {
        return DB::transaction(function () use ($request) {
            try {
                $user = $this->validateAdminAndSuperAdmin($request);
                $districts = ($user->type == 'superadmin')
                    ? null
                    : (($user->district == '1st')
                        ? ['Baco', 'City Of Calapan (Capital)', 'Naujan', 'Pola', 'Puerto Galera', 'San Teodoro', 'Socorro', 'Victoria']
                        : ['Bansud', 'Bongabong', 'Bulalacao (San Pedro)', 'Gloria', 'Mansalay', 'Pinamalayan', 'Roxas']);
                $query = EducationalAssistance::query();
                if ($districts !== null) {
                    $query->whereIn('municipality', $districts);
                }
                $educationalRequests = $query->get();
                $organizedData = [];
                foreach ($educationalRequests as $request) {
                    $municipality = $request->municipality;
                    $barangay = $request->barangay;
                    if (!isset($organizedData[$municipality])) {
                        $organizedData[$municipality] = [];
                    }
                    if (!isset($organizedData[$municipality][$barangay])) {
                        $organizedData[$municipality][$barangay] = 1;
                    } else {
                        $organizedData[$municipality][$barangay]++;
                    }
                }
                $formattedData = [];
                foreach ($organizedData as $municipality => $barangays) {
                    $barangayData = [];
                    foreach ($barangays as $barangay => $count) {
                        $barangayData[] = [
                            'barangay' => $barangay,
                            'count' => $count
                        ];
                    }
                    $formattedData[] = [
                        'municipality' => $municipality,
                        'barangays' => $barangayData
                    ];
                }
                return response()->json($formattedData);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        });
    }

    public function getGenderEducationalRequest(Request $request)
    {
        return DB::transaction(function () use ($request) {
            try {
                $user = $this->validateAdminAndSuperAdmin($request);
                $districts = ($user->type == 'superadmin')
                    ? null
                    : (($user->district == '1st')
                        ? ['Baco', 'City Of Calapan (Capital)', 'Naujan', 'Pola', 'Puerto Galera', 'San Teodoro', 'Socorro', 'Victoria']
                        : ['Bansud', 'Bongabong', 'Bulalacao (San Pedro)', 'Gloria', 'Mansalay', 'Pinamalayan', 'Roxas']);
                $query = EducationalAssistance::selectRaw('beneficiary_gender as gender, municipality, COUNT(*) as count')
                    ->groupBy('gender', 'municipality');
                if ($districts !== null) {
                    $query->whereIn('municipality', $districts);
                }
                $genderMunicipalityCounts = $query->get();
                $result = [];
                foreach ($genderMunicipalityCounts as $record) {
                    if (!isset($result[$record->gender])) {
                        $result[$record->gender] = [
                            'count' => 0,
                            'municipality' => []
                        ];
                    }
                    $result[$record->gender]['count'] += $record->count;
                    $result[$record->gender]['municipality'][$record->municipality] = $record->count;
                }
                return response()->json($result);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        });
    }


    public function getGenderMedicalRequest(Request $request)
    {
        return DB::transaction(function () use ($request) {
            try {
                $user = $this->validateAdminAndSuperAdmin($request);
                if ($user->type === 'superadmin') {
                    $query = MedicalRequest::selectRaw('gender, medical_requests.municipality, COUNT(*) as count')
                        ->join('hospitals', 'medical_requests.hospital', '=', 'hospitals.hospital_acronym')
                        ->whereIn('hospitals.assist_by_staff_from', ['1st', '2nd'])
                        ->groupBy('gender', 'medical_requests.municipality');
                } else {
                    $hospitals = Hospital::join('medical_requests', 'hospitals.hospital_acronym', '=', 'medical_requests.hospital')
                        ->where('hospitals.deleted_at', null)
                        ->pluck('assist_by_staff_from');
                    $districts = [];
                    foreach ($hospitals as $hospital) {
                        if ($hospital === '1st' && $user->district === '1st') {
                            $districts[] = $hospital;
                        } elseif ($hospital === '2nd' && $user->district === '2nd') {
                            $districts[] = $hospital;
                        }
                    }
                    $query = MedicalRequest::selectRaw('gender, medical_requests.municipality, COUNT(*) as count')
                        ->join('hospitals', 'medical_requests.hospital', '=', 'hospitals.hospital_acronym')
                        ->whereIn('hospitals.assist_by_staff_from', $districts)
                        ->groupBy('gender', 'medical_requests.municipality');
                }
                $genderMunicipalityCounts = $query->get();
                $result = [];
                foreach ($genderMunicipalityCounts as $record) {
                    if (!isset($result[$record->gender])) {
                        $result[$record->gender] = [
                            'count' => 0,
                            'municipality' => []
                        ];
                    }
                    $result[$record->gender]['count'] += $record->count;
                    $result[$record->gender]['municipality'][$record->municipality] = $record->count;
                }
                return response()->json($result);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        });
    }



    public function getMunicipalityBarangayData(Request $request)
    {
        return DB::transaction(function () use ($request) {
            try {
                $user = $this->validateAdminAndSuperAdmin($request);
                if ($user->type === 'superadmin') {
                    $hospitalRequests = MedicalRequest::all();
                } else {
                    $districts = ($user->district == '1st')
                        ? ['1st']
                        : ['2nd'];
                    $hospitals = Hospital::where('assist_by_staff_from', $districts)->pluck('hospital_acronym');
                    $hospitalRequests = MedicalRequest::whereIn('hospital', $hospitals)->get();
                }
                $organizedData = [];
                foreach ($hospitalRequests as $request) {
                    $municipality = $request->municipality;
                    $barangay = $request->barangay;
                    if (!isset($organizedData[$municipality])) {
                        $organizedData[$municipality] = [];
                    }
                    if (!isset($organizedData[$municipality][$barangay])) {
                        $organizedData[$municipality][$barangay] = 1;
                    } else {
                        $organizedData[$municipality][$barangay]++;
                    }
                }
                $formattedData = [];
                foreach ($organizedData as $municipality => $barangays) {
                    $barangayData = [];
                    foreach ($barangays as $barangay => $count) {
                        $barangayData[] = [
                            'barangay' => $barangay,
                            'count' => $count
                        ];
                    }
                    $formattedData[] = [
                        'municipality' => $municipality,
                        'barangays' => $barangayData
                    ];
                }
                return response()->json($formattedData);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        });
    }


    public function getAllHospitalsWithServiceOffers(Request $request)
    {
        return DB::transaction(function () use ($request) {
            try {
                $user = $this->validateAdminAndSuperAdmin($request);
                $hospitalQuery = DB::table('hospitals')->whereNull('deleted_at');
                if ($user->type != 'superadmin') {
                    $districtFilter = $user->district == '1st' ? '1st' : '2nd';
                    $hospitalQuery->where('assist_by_staff_from', $districtFilter);
                }
                $hospitals = $hospitalQuery->get();
                $hospitalDetails = [];
                foreach ($hospitals as $hospital) {
                    $hospitalId = $hospital->id;
                    $hospitalName = $hospital->hospital_name;
                    $hospitalAcronym = $hospital->hospital_acronym;
                    $activeOffers = DB::table('hospital_requests')
                        ->where('hospital_id', $hospitalId)
                        ->where('status', 'active')
                        ->whereNull('deleted_at')
                        ->pluck('service_offer');
                    $inactiveOffers = DB::table('hospital_requests')
                        ->where('hospital_id', $hospitalId)
                        ->where('status', 'inactive')
                        ->whereNull('deleted_at')
                        ->pluck('service_offer');
                    $hospitalDetails[] = [
                        'hospital_name' => $hospitalName,
                        'hospital_acronym' => $hospitalAcronym,
                        'active_offers' => $activeOffers,
                        'inactive_offers' => $inactiveOffers,
                    ];
                }
                return response()->json([
                    'hospitals' => $hospitalDetails,
                ]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        });
    }


    /**
     * Display a listing of the resource.
     */

    public function getAllHospital(Request $request)
    {
        return DB::transaction(function () use ($request) {
            try {
                $user = $this->validateAdminAndSuperAdmin($request);
                $hospitalQuery = DB::table('hospitals')->whereNull('deleted_at');
                if ($user->type != 'superadmin') {
                    $districtFilter = $user->district == '1st' ? '1st' : '2nd';
                    $hospitalQuery->where('assist_by_staff_from', $districtFilter);
                }
                $totalHospitals = (clone $hospitalQuery)->count();
                $activeHospitals = (clone $hospitalQuery)->where('status', 'active')->count();
                $inactiveHospitals = (clone $hospitalQuery)->where('status', 'inactive')->count();
                $totalHospitalNames = (clone $hospitalQuery)->pluck('hospital_name');
                $activeHospitalNames = (clone $hospitalQuery)->where('status', 'active')->pluck('hospital_name');
                $inactiveHospitalNames = (clone $hospitalQuery)->where('status', 'inactive')->pluck('hospital_name');
                return response()->json([
                    'total' => [
                        'count' => $totalHospitals,
                        'names' => $totalHospitalNames,
                    ],
                    'active' => [
                        'count' => $activeHospitals,
                        'names' => $activeHospitalNames,
                    ],
                    'inactive' => [
                        'count' => $inactiveHospitals,
                        'names' => $inactiveHospitalNames,
                    ],
                ]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        });
    }


    private function validateAdminAndSuperAdmin(Request $request)
    {
        $token = $request->bearerToken();
        if (!$token) {
            throw new \Exception('Unauthorized', 401);
        }
        $decryptedId = Crypt::decrypt($token);
        $user = User::find($decryptedId);
        if (!$user || $user->type !== 'admin' && $user->type !== 'superadmin') {
            throw new \Exception('User is not an admin', 400);
        }
        return $user;
    }
}
