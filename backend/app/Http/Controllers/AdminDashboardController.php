<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Hospital;
use App\Models\HospitalRequest;
use App\Models\EducationalAssistance;
use App\Models\Tupad;
use App\Models\TupadSlot;
use App\Models\MedicalRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AdminDashboardController extends Controller
{

    public function getAllHospitalsWithServiceOffers()
    {
        return DB::transaction(function () {
            $hospitals = DB::table('hospitals')
                ->whereNull('deleted_at')
                ->get();
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
        });
    }


    /**
     * Display a listing of the resource.
     */
    public function getAllHospital()
    {
        return DB::transaction(function () {
            $totalHospitals = DB::table('hospitals')->whereNull('deleted_at')->count();
            $activeHospitals = DB::table('hospitals')->where('status', 'active')->whereNull('deleted_at')->count();
            $inactiveHospitals = DB::table('hospitals')->where('status', 'inactive')->whereNull('deleted_at')->count();
            $totalHospitalNames = DB::table('hospitals')->whereNull('deleted_at')->pluck('hospital_name');
            $activeHospitalNames = DB::table('hospitals')->where('status', 'active')->whereNull('deleted_at')->pluck('hospital_name');
            $inactiveHospitalNames = DB::table('hospitals')->where('status', 'inactive')->whereNull('deleted_at')->pluck('hospital_name');
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
        });
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
