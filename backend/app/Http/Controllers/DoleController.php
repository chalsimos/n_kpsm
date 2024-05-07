<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Tupad;
use App\Models\TupadSlot;
use App\Models\TupadCode;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class DoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    public function tupad_request_status_checker(Request $request)
    {
        try {
            $code = $request->input('code');
            $tupadCode = TupadCode::where('code_generated', $code)->first();
            if (!$tupadCode) {
                return response()->json("Invalid Tupad code", 404);
            }
            $tupads = Tupad::where('used_code_id', $tupadCode->id)->first();
            $status = $tupads->status;
            $reason = $tupads->decline_reason;
            if ($status === 'pending') {
                return response()->json("Tupad request is still pending", 200);
            }
            if ($status === "accepted") {
                return response()->json("Tupad request is accepted", 200);
            }
            if ($status === "declined") {
                return response()->json("Tupad request is declined reason ($reason) ", 200);
            }
            return response()->json("Unknown status", 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getAll_captains_tupad_invites(Request $request)
    {
        try {
            $tupads = Tupad::where('status', 'accepted')
                ->leftJoin('users', 'tupads.given_by_captainID', '=', 'users.id')
                ->select('tupads.*', 'users.name as captain_name')
                ->get();
            return response()->json($tupads, 200);
            return response()->json(['message' => 'Codes generated and saved successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function accept_tupad_invites(Request $request, $id)
    {
        try {
            $tupadRequest = Tupad::findOrFail($id);
            if ($tupadRequest->save()) {
                $tupadRequest->status = 'accepted';
                $tupadRequest->save();
                return response()->json($tupadRequest, 200);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with("error", $e->getMessage());
        }
    }
    public function decline_tupad_invites(Request $request, $id)
    {
        try {
            $tupadRequest = Tupad::findOrFail($id);
            $validatedData = $request->validate([
                'decline_reason' => 'required',
            ]);
            $tupadRequest->decline_reason = $validatedData['decline_reason'];
            if ($tupadRequest->save()) {
                $tupadRequest->status = 'declined';
                $tupadRequest->save();
                return response()->json($tupadRequest, 200);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with("error", $e->getMessage());
        }
    }
    public function captain_tupad_invite(Request $request)
    {
        try {
            $user = $this->validateCaptain($request);

            $tupads = Tupad::where('given_by_captainID', $user->id)
                ->leftJoin('tupad_codes', 'tupads.used_code_id', '=', 'tupad_codes.id')
                ->select('tupads.*', 'tupad_codes.code_generated')
                ->get();

            return response()->json($tupads, 200);
            return response()->json(['message' => 'Codes generated and saved successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function code_checker(Request $request)
    {
        try {
            $code = $request->input('code');
            $tupadCode = TupadCode::where('code_generated', $code)->first();
            if (!$tupadCode) {
                return response()->json(['error' => 'Code not found'], 404);
            }
            if ($tupadCode->status !== 'active') {
                return response()->json(['error' => 'Code already used'], 400);
            }
            $id = $tupadCode->id;
            $captainId = $tupadCode->captain_id;
            $encryptedId = [
                'tupad_codeId' => encrypt($id),
                'captain_id' => encrypt($captainId)
            ];
            return response()->json(['encrypted_id' => $encryptedId], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function tupad_code_list(Request $request)
    {
        try {

            $user = $this->validateCaptain($request);
            $codes = TupadCode::where('captain_id', $user->id)
                ->with(['slot' => function ($query) {
                    $query->select('id', 'month_year_available');
                }])
                ->get();
            $transformedData = $codes->map(function ($code) {
                return [
                    'id' => $code->id,
                    'captain_id' => $code->captain_id,
                    'slot_id' => $code->slot_id,
                    'code_generated' => $code->code_generated,
                    'status' => $code->status,
                    'created_at' => $code->created_at,
                    'updated_at' => $code->updated_at,
                    'month_year_available' => $code->slot->month_year_available,
                ];
            });
            return response()->json($transformedData, 200);
            return response()->json(['message' => 'Codes generated and saved successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function generateCodeAndSave(Request $request)
    {
        try {

            $user = $this->validateCaptain($request);
            $slotsWithNoCode = TupadSlot::where('captain_id', $user->id)
                ->where('status', 'No Code')
                ->get();
            if ($slotsWithNoCode->isEmpty()) {
                return response()->json(['message' => 'No slots available for code generation'], 400);
            }
            $slotsWithNoCode->each(function ($slot) {
                $slot->status = 'Code Generated';
                $slot->save();
            });
            foreach ($slotsWithNoCode as $slot) {
                for ($i = 0; $i < $slot->slot_get; $i++) {
                    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!#$%&():;=?@[]^{|}~';
                    $codeGenerated = 'TUPAD_CODE_' . str_shuffle(substr(str_shuffle($characters), 0, 10));
                    $code = new TupadCode();
                    $code->captain_id = $user->id;
                    $code->slot_id = $slot->id;
                    $code->code_generated = $codeGenerated;
                    $code->status = 'active';
                    $code->save();
                }
            }

            return response()->json(['message' => 'Codes generated and saved successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function captain_tupad_slot(Request $request)
    {
        try {

            $user = $this->validateCaptain($request);
            $slots = TupadSlot::where('captain_id', $user->id)->get();
            return response()->json(['data' => $slots], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
    public function captain_list(Request $request)
    {
        try {
            $captains = User::select('id','name', 'email')->where('type', 'captain')->get();
            return response()->json($captains, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function allCaptain_tupadSlot(Request $request, $id)
    {
        try {
            $allCaptain_tupadSlot = User::where('type', 'captain')
                ->leftJoin('tupad_slots', 'users.id', '=', 'tupad_slots.captain_id')
                ->where('users.id', $id)
                ->select('users.name', 'tupad_slots.slot_get', 'tupad_slots.slot_left', 'tupad_slots.month_year_available', 'tupad_slots.date_obtained')
                ->get();
            return response()->json($allCaptain_tupadSlot, 200);
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
                'slot_get' => 'required|integer',
                'month_year_available' => 'required',
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
            $slot->status = 'No Code';
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
            $usedCodeId = decrypt($request->input('used_code_id'));
            $givenByCaptainID = decrypt($request->input('given_by_captainID'));
            $data->used_code_id = $usedCodeId;
            $data->given_by_captainID = $givenByCaptainID;
            $data->save();
            $tupadCode = TupadCode::find($data->used_code_id);
            $slotId = $tupadCode->slot_id;
            $slot = TupadSlot::find($slotId);
            $slot->slot_left -= 1;
            $slot->save();
            TupadCode::where('id', $usedCodeId)->update(['status' => 'Code Used']);
            DB::commit();
            return response()->json(['message' => 'Tupad saved successfully'], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    private function validateCaptain(Request $request)
    {
        $token = $request->bearerToken();
        if (!$token) {
            throw new \Exception('Unauthorized', 401);
        }
        $decryptedId = Crypt::decrypt($token);
        $user = User::find($decryptedId);
        if (!$user || $user->type !== 'captain') {
            throw new \Exception('User is not a captain', 400);
        }
        return $user;
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
