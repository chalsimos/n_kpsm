<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Tupad;
use App\Models\TupadSlot;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function captain_list(Request $request)
    {
        try {
            $captains = User::where('type', 'captain')
                            ->leftJoin('tupad_slots', 'users.id', '=', 'tupad_slots.captain_id')
                            ->select('users.*', 'tupad_slots.slot_get', 'tupad_slots.slot_left', 'tupad_slots.month_year_available', 'tupad_slots.date_obtained')
                            ->get();
            return response()->json($captains, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function give_slot(Request $request, $captain_id)
    {
        try {
            $captain = User::findOrFail($captain_id);
            if ($captain->type !== 'captain') {
                return response()->json(['error' => 'User is not a captain'], 400);
            }
            $validator = Validator::make($request->all(), [
                'slot_get' => 'required|integer|min:0',
                'month_year_available' => 'required|date_format:Y-m',
            ]);
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }
            $slot = new TupadSlot();
            $slot->captain_id = $captain_id;
            $slot->slot_get = $request->input('slot_get');
            $slot->slot_left = $request->input('slot_get');
            $slot->month_year_available = $request->input('month_year_available');
            $slot->date_obtained = now()->toDateString();
            $slot->save();

            return response()->json(['data' => $slot], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function save_tupad(Request $request)
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
            'benificiaryfullname' => 'required|string|max:255',
            'contactnumber' => 'required|integer|digits_between:1,11',
            'idNum' => 'required|string|max:255',
            'sitio' => 'required|string|max:255',
            'idType' => 'required|string|max:255',
            'civilstatus' => 'required|string|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        try {
            DB::beginTransaction();
            $data = new Tupad();
            $data->firstname = $request->input('firstname');
            $data->middlename = $request->input('middlename');
            $data->lastname = $request->input('lastname');
            $data->age = $request->input('age');
            $data->birthday = $request->input('birthday');
            $data->gender = $request->input('gender');
            $data->province = $request->input('province');
            $data->municipality = $request->input('municipality');
            $data->barangay = $request->input('barangay');
            $data->benificiary_name = $request->input('benificiaryfullname');
            $data->contact_number = $request->input('contactnumber');
            $data->id_number = $request->input('idNum');
            $data->sitio = $request->input('sitio');
            $data->id_type = $request->input('idType');
            $data->civil_status = $request->input('civilstatus');
            $data->status = 'pending';
            $data->save();
            DB::commit();
            return response()->json(['message' => 'Tupad saved successfully'], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
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
