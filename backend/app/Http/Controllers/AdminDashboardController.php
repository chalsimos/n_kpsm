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
    public function getAgeEducationalAgeRequest(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        if (!$startDate && !$endDate) {
            $startDate = Carbon::now()->startOfMonth()->toDateString();
            $endDate = Carbon::now()->endOfMonth()->toDateString();
        }

        return DB::transaction(function () use ($request, $startDate, $endDate) {
            try {
                $user = $this->validateAdminAndSuperAdmin($request);

                // Define districts based on user type and district
                $districts = ($user->type == 'superadmin')
                    ? null
                    : (($user->district == '1st')
                        ? ['Baco', 'City Of Calapan (Capital)', 'Naujan', 'Pola', 'Puerto Galera', 'San Teodoro', 'Socorro', 'Victoria']
                        : ['Bansud', 'Bongabong', 'Bulalacao (San Pedro)', 'Gloria', 'Mansalay', 'Pinamalayan', 'Roxas']);

                // Query to fetch data
                $query = EducationalAssistance::whereBetween('created_at', [$startDate, $endDate])
                    ->selectRaw('school, beneficiary_age as age, municipality, COUNT(*) as count')
                    ->groupBy('school', 'beneficiary_age', 'municipality');

                if ($districts !== null) {
                    $query->whereIn('municipality', $districts);
                }

                $ageSchoolMunicipalityCounts = $query->get();

                // Process the results
                $result = [];
                foreach ($ageSchoolMunicipalityCounts as $record) {
                    $schoolName = $record->school;

                    if (!isset($result[$schoolName])) {
                        $result[$schoolName] = [];
                    }

                    $result[$schoolName][] = [
                        'age' => $record->age . ' years old',
                        'municipality' => $record->municipality,
                        'count' => $record->count
                    ];
                }

                return response()->json($result);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        });
    }


    public function getAgeBracketMedicalRequest(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        if (!$startDate || !$endDate) {
            $startDate = now()->startOfMonth()->toDateString();
            $endDate = now()->endOfMonth()->toDateString();
        }

        return DB::transaction(function () use ($request, $startDate, $endDate) {
            try {
                $user = $this->validateAdminAndSuperAdmin($request);

                $query = MedicalRequest::selectRaw("
                CASE
                    WHEN TIMESTAMPDIFF(YEAR, birthday, CURDATE()) < 1 THEN 'Newborn'
                    WHEN TIMESTAMPDIFF(YEAR, birthday, CURDATE()) BETWEEN 1 AND 3 THEN 'Baby'
                    WHEN TIMESTAMPDIFF(YEAR, birthday, CURDATE()) BETWEEN 4 AND 17 THEN 'Child'
                    WHEN TIMESTAMPDIFF(YEAR, birthday, CURDATE()) BETWEEN 18 AND 35 THEN 'Young Adult'
                    WHEN TIMESTAMPDIFF(YEAR, birthday, CURDATE()) BETWEEN 36 AND 55 THEN 'Middle Aged Adult'
                    WHEN TIMESTAMPDIFF(YEAR, birthday, CURDATE()) > 55 THEN 'Old Adult'
                    ELSE 'Unknown'
                END as age_bracket,
                TIMESTAMPDIFF(YEAR, birthday, CURDATE()) as age_years,
                TIMESTAMPDIFF(MONTH, birthday, CURDATE()) as age_months,
                medical_requests.municipality,
                COUNT(*) as count
            ")
                    ->join('hospitals', 'medical_requests.hospital', '=', 'hospitals.hospital_acronym')
                    ->whereDate('medical_requests.created_at', '>=', $startDate)
                    ->whereDate('medical_requests.created_at', '<=', $endDate)
                    ->groupBy('age_bracket', 'medical_requests.municipality', 'age_years', 'age_months');

                if ($user->type === 'superadmin') {
                    $query->whereIn('hospitals.assist_by_staff_from', ['1st', '2nd']);
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
                    $query->whereIn('hospitals.assist_by_staff_from', $districts);
                }

                $ageBracketMunicipalityCounts = $query->get();

                $result = [];
                foreach ($ageBracketMunicipalityCounts as $record) {
                    if (!isset($result[$record->age_bracket])) {
                        $result[$record->age_bracket] = [];
                    }
                    $ageString = $record->age_years < 1
                        ? "{$record->age_months} month" . ($record->age_months > 1 ? 's' : '') . " old"
                        : "{$record->age_years} year" . ($record->age_years > 1 ? 's' : '') . " old";

                    $result[$record->age_bracket][] = [
                        'age' => $ageString,
                        'municipality' => $record->municipality,
                        'count' => $record->count
                    ];
                }

                return response()->json($result);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        });
    }

    public function getEducationalRequestsData(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        if (!$startDate && !$endDate) {
            $startDate = Carbon::now()->startOfMonth()->toDateString();
            $endDate = Carbon::now()->endOfMonth()->toDateString();
        }
        $data = DB::transaction(function () use ($startDate, $endDate) {
            $query = EducationalAssistance::select(DB::raw('YEAR(created_at) as year'), DB::raw('COUNT(*) as total_per_year'))
                ->groupBy('year')
                ->whereBetween('created_at', [$startDate, $endDate]);
            $yearsData = $query->get()->map(function ($yearData) use ($startDate, $endDate) {
                $year = $yearData->year;
                $totalPerYear = $yearData->total_per_year;
                $monthsQuery = EducationalAssistance::whereYear('created_at', $year)
                    ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as total_per_month'))
                    ->groupBy('month')
                    ->whereBetween('created_at', [$startDate, $endDate]);
                $monthsData = $monthsQuery->get()->map(function ($monthData) use ($year, $startDate, $endDate) {
                    $month = $monthData->month;
                    $totalPerMonth = $monthData->total_per_month;
                    $monthName = Carbon::create()->month($month)->format('F');
                    $schoolsQuery = EducationalAssistance::whereYear('created_at', $year)
                        ->whereMonth('created_at', $month)
                        ->groupBy('school')
                        ->select('school', DB::raw('COUNT(*) as total_per_school'))
                        ->whereBetween('created_at', [$startDate, $endDate]);
                    $schoolData = $schoolsQuery->get()->map(function ($schoolData) use ($year, $month, $startDate, $endDate) {
                        $school = $schoolData->school;
                        $totalPerSchool = $schoolData->total_per_school;
                        $municipalitiesQuery = EducationalAssistance::whereYear('created_at', $year)
                            ->whereMonth('created_at', $month)
                            ->where('school', $school)
                            ->groupBy('municipality')
                            ->select('municipality', DB::raw('COUNT(*) as total_per_municipality'))
                            ->whereBetween('created_at', [$startDate, $endDate]);
                        $municipalitiesData = $municipalitiesQuery->get()->map(function ($municipalityData) use ($year, $month, $school, $startDate, $endDate) {
                            $municipality = $municipalityData->municipality;
                            $totalPerMunicipality = $municipalityData->total_per_municipality;
                            $barangaysQuery = EducationalAssistance::whereYear('created_at', $year)
                                ->whereMonth('created_at', $month)
                                ->where('school', $school)
                                ->where('municipality', $municipality)
                                ->groupBy('barangay')
                                ->select('barangay', DB::raw('COUNT(*) as total_per_barangay'))
                                ->whereBetween('created_at', [$startDate, $endDate]);
                            $barangaysData = $barangaysQuery->get()->map(function ($barangayData) use ($year, $month, $school, $municipality, $startDate, $endDate) {
                                $barangay = $barangayData->barangay;
                                $totalPerBarangay = $barangayData->total_per_barangay;
                                $detailsQuery = EducationalAssistance::whereYear('created_at', $year)
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
                                    ->whereBetween('created_at', [$startDate, $endDate]);
                                $details = $detailsQuery->get()->map(function ($detail) {
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
                                })->values();
                                return [
                                    'barangay' => $barangay,
                                    'total_per_barangay' => $totalPerBarangay,
                                    'details' => $details,
                                ];
                            })->values();
                            return [
                                'municipality' => $municipality,
                                'total_per_municipality' => $totalPerMunicipality,
                                'barangays' => $barangaysData,
                            ];
                        })->values();
                        return [
                            'school' => $school,
                            'total_per_school' => $totalPerSchool,
                            'municipalities' => $municipalitiesData,
                        ];
                    })->values();
                    return [
                        'month' => $monthName,
                        'total_per_month' => $totalPerMonth,
                        'school' => $schoolData,
                    ];
                })->values();
                return [
                    'year' => $year,
                    'total_per_year' => $totalPerYear,
                    'months' => $monthsData,
                ];
            })->values();
            return $yearsData;
        });
        return response()->json($data);
    }


    public function getMedicalRequestsData(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        if (!$startDate && !$endDate) {
            $startDate = Carbon::now()->startOfMonth()->toDateString();
            $endDate = Carbon::now()->endOfMonth()->toDateString();
        }
        $data = DB::transaction(function () use ($startDate, $endDate) {
            $query = MedicalRequest::select(DB::raw('YEAR(created_at) as year'), DB::raw('COUNT(*) as total_per_year'))
                ->groupBy('year')
                ->whereBetween('created_at', [$startDate, $endDate]);
            $yearsData = $query->get()->map(function ($yearData) use ($startDate, $endDate) {
                $year = $yearData->year;
                $totalPerYear = $yearData->total_per_year;
                $monthsQuery = MedicalRequest::whereYear('created_at', $year)
                    ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as total_per_month'))
                    ->groupBy('month')
                    ->whereBetween('created_at', [$startDate, $endDate]);
                $monthsData = $monthsQuery->get()->map(function ($monthData) use ($year, $startDate, $endDate) {
                    $month = $monthData->month;
                    $totalPerMonth = $monthData->total_per_month;
                    $monthName = Carbon::create()->month($month)->format('F');
                    $hospitalsQuery = MedicalRequest::whereYear('created_at', $year)
                        ->whereMonth('created_at', $month)
                        ->groupBy('hospital')
                        ->select('hospital', DB::raw('COUNT(*) as total_per_hospital'))
                        ->whereBetween('created_at', [$startDate, $endDate]);
                    $hospitalsData = $hospitalsQuery->get()->map(function ($hospitalData) use ($year, $month, $startDate, $endDate) {
                        $hospital = $hospitalData->hospital;
                        $totalPerHospital = $hospitalData->total_per_hospital;
                        $municipalitiesQuery = MedicalRequest::whereYear('created_at', $year)
                            ->whereMonth('created_at', $month)
                            ->where('hospital', $hospital)
                            ->groupBy('municipality')
                            ->select('municipality', DB::raw('COUNT(*) as total_per_municipality'))
                            ->whereBetween('created_at', [$startDate, $endDate]);
                        $municipalitiesData = $municipalitiesQuery->get()->map(function ($municipalityData) use ($year, $month, $hospital, $startDate, $endDate) {
                            $municipality = $municipalityData->municipality;
                            $totalPerMunicipality = $municipalityData->total_per_municipality;
                            $barangaysQuery = MedicalRequest::whereYear('created_at', $year)
                                ->whereMonth('created_at', $month)
                                ->where('hospital', $hospital)
                                ->where('municipality', $municipality)
                                ->groupBy('barangay')
                                ->select('barangay', DB::raw('COUNT(*) as total_per_barangay'))
                                ->whereBetween('created_at', [$startDate, $endDate]);
                            $barangaysData = $barangaysQuery->get()->map(function ($barangayData) use ($year, $month, $hospital, $municipality, $startDate, $endDate) {
                                $barangay = $barangayData->barangay;
                                $totalPerBarangay = $barangayData->total_per_barangay;
                                $detailsQuery = MedicalRequest::whereYear('created_at', $year)
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
                                    ->whereBetween('created_at', [$startDate, $endDate]);
                                $details = $detailsQuery->get()->map(function ($detail) {
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
                                })->values();
                                return [
                                    'barangay' => $barangay,
                                    'total_per_barangay' => $totalPerBarangay,
                                    'details' => $details,
                                ];
                            })->values();
                            return [
                                'municipality' => $municipality,
                                'total_per_municipality' => $totalPerMunicipality,
                                'barangays' => $barangaysData,
                            ];
                        })->values();
                        return [
                            'hospital' => $hospital,
                            'total_per_hospital' => $totalPerHospital,
                            'municipalities' => $municipalitiesData,
                        ];
                    })->values();
                    return [
                        'month' => $monthName,
                        'total_per_month' => $totalPerMonth,
                        'hospitals' => $hospitalsData,
                    ];
                })->values();
                return [
                    'year' => $year,
                    'total_per_year' => $totalPerYear,
                    'months' => $monthsData,
                ];
            })->values();
            return $yearsData;
        });
        return response()->json($data);
    }

    public function getData(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        if (!$startDate && !$endDate) {
            $startDate = Carbon::now()->startOfMonth()->toDateString();
            $endDate = Carbon::now()->endOfMonth()->toDateString();
        }
        $data = DB::transaction(function () use ($startDate, $endDate) {
            $query = Tupad::select(DB::raw('YEAR(created_at) as year'), DB::raw('COUNT(*) as total_per_year'))
                ->groupBy('year')
                ->whereBetween('created_at', [$startDate, $endDate]);
            $yearsData = $query->get()->map(function ($yearData) use ($startDate, $endDate) {
                $year = $yearData->year;
                $totalPerYear = $yearData->total_per_year;
                $monthsQuery = Tupad::whereYear('created_at', $year)
                    ->whereBetween('created_at', [$startDate, $endDate]);
                $monthsData = $monthsQuery->get()->groupBy(function ($item) {
                    return Carbon::parse($item->month_year_available)->format('F');
                })->map(function ($items, $month) use ($startDate, $endDate) {
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
                })->values();
                return [
                    'year' => $year,
                    'total_per_year' => $totalPerYear,
                    'months' => $monthsData,
                ];
            })->values();
            return $yearsData;
        });
        return response()->json($data);
    }

    public function getMunicipalityBarangayEducationalData(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        if (!$startDate && !$endDate) {
            $startDate = Carbon::now()->startOfMonth()->toDateString();
            $endDate = Carbon::now()->endOfMonth()->toDateString();
        }
        return DB::transaction(function () use ($request, $startDate, $endDate) {
            try {
                $user = $this->validateAdminAndSuperAdmin($request);
                $districts = ($user->type == 'superadmin')
                    ? null
                    : (($user->district == '1st')
                        ? ['Baco', 'City Of Calapan (Capital)', 'Naujan', 'Pola', 'Puerto Galera', 'San Teodoro', 'Socorro', 'Victoria']
                        : ['Bansud', 'Bongabong', 'Bulalacao (San Pedro)', 'Gloria', 'Mansalay', 'Pinamalayan', 'Roxas']);
                $query = EducationalAssistance::whereBetween('created_at', [$startDate, $endDate]);
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
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        if (!$startDate && !$endDate) {
            $startDate = Carbon::now()->startOfMonth()->toDateString();
            $endDate = Carbon::now()->endOfMonth()->toDateString();
        }
        return DB::transaction(function () use ($request, $startDate, $endDate) {
            try {
                $user = $this->validateAdminAndSuperAdmin($request);
                $districts = ($user->type == 'superadmin')
                    ? null
                    : (($user->district == '1st')
                        ? ['Baco', 'City Of Calapan (Capital)', 'Naujan', 'Pola', 'Puerto Galera', 'San Teodoro', 'Socorro', 'Victoria']
                        : ['Bansud', 'Bongabong', 'Bulalacao (San Pedro)', 'Gloria', 'Mansalay', 'Pinamalayan', 'Roxas']);
                $query = EducationalAssistance::whereBetween('created_at', [$startDate, $endDate])
                    ->selectRaw('beneficiary_gender as gender, municipality, COUNT(*) as count')
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
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        if (!$startDate || !$endDate) {
            $startDate = now()->startOfMonth()->toDateString();
            $endDate = now()->endOfMonth()->toDateString();
        }
        return DB::transaction(function () use ($request, $startDate, $endDate) {
            try {
                $user = $this->validateAdminAndSuperAdmin($request);
                $query = MedicalRequest::selectRaw('gender, medical_requests.municipality, COUNT(*) as count')
                    ->join('hospitals', 'medical_requests.hospital', '=', 'hospitals.hospital_acronym');
                if ($user->type === 'superadmin') {
                    $query->whereIn('hospitals.assist_by_staff_from', ['1st', '2nd']);
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
                    $query->whereIn('hospitals.assist_by_staff_from', $districts);
                }
                $query->whereDate('medical_requests.created_at', '>=', $startDate)
                    ->whereDate('medical_requests.created_at', '<=', $endDate)
                    ->groupBy('gender', 'medical_requests.municipality');
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
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        if (!$startDate || !$endDate) {
            $startDate = now()->startOfMonth()->toDateString();
            $endDate = now()->endOfMonth()->toDateString();
        }
        return DB::transaction(function () use ($request, $startDate, $endDate) {
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
                    $createdAt = $request->created_at->toDateString();
                    if ($createdAt >= $startDate && $createdAt <= $endDate) {
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
