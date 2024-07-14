<?php

namespace App\Http\Controllers;


use App\Models\BudgetAllocation as Budget;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;

class BudgetAllocation extends Controller
{
    private function validateSuperAdmin(Request $request)
    {
        $token = $request->bearerToken();
        if (!$token) {
            throw new \Exception('Unauthorized', 401);
        }
        $decryptedId = Crypt::decrypt($token);
        $user = User::find($decryptedId);
        if (!$user || $user->type !== 'superadmin') {
            throw new \Exception('User is not a SuperAdmin', 400);
        }
        return $user;
    }
    public function save_budget_allocation(Request $request)
    {
        $user = $this->validateSuperAdmin($request);
        $validator = Validator::make($request->all(), [
            'total_budget' => 'required',
            'budget_to_hospital' => 'required',
            'year' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        try {
            DB::beginTransaction();
            $existingAllocation = Budget::where('budget_to_hospital', $request->input('budget_to_hospital'))
                ->where('year', $request->input('year'))
                ->first();
            if ($existingAllocation) {
                $existingAllocation->total_budget += $request->input('total_budget');
                $existingAllocation->budget_left += $request->input('total_budget');
                $existingAllocation->save();
            } else {
                $newAllocation = new Budget();
                $newAllocation->total_budget = $request->input('total_budget');
                $newAllocation->budget_left = $request->input('total_budget');
                $newAllocation->budget_to_hospital = $request->input('budget_to_hospital');
                $newAllocation->year = $request->input('year');
                $newAllocation->added_by = $request->input('added_by');
                $newAllocation->status = 'active';
                $newAllocation->added_by = $user->id;
                $newAllocation->save();
            }
            DB::commit();
            return response()->json(['message' => 'Budget allocation saved successfully'], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function get_all_budget_allocations(Request $request)
    {
        $year = $request->input('year');
        if (!$year) {
            $year = Carbon::now()->year;
        }
        $allocations = Budget::where('year', $year)->orderBy('year', 'asc')->get();
        return response()->json(['data' => $allocations], 200);
    }
    public function get_unique_hospitals()
    {
        try {
            $currentYear = date('Y');
            $hospitals = Budget::select('budget_to_hospital')
                ->distinct()
                ->pluck('budget_to_hospital');
            $result = [];
            foreach ($hospitals as $hospital) {
                $currentYearBudget = Budget::where('budget_to_hospital', $hospital)
                    ->where('year', $currentYear)
                    ->first(['total_budget', 'budget_left', 'total_expenses', 'year']);
                $nextYearBudget = null;
                if (!$currentYearBudget || $currentYearBudget->budget_left == 0) {
                    $nextYear = $currentYear + 1;
                    while (true) {
                        $potentialNextYearBudget = Budget::where('budget_to_hospital', $hospital)
                            ->where('year', $nextYear)
                            ->first(['total_budget', 'budget_left', 'total_expenses', 'year']);
                        if ($potentialNextYearBudget) {
                            if ($potentialNextYearBudget->budget_left != 0) {
                                $nextYearBudget = $potentialNextYearBudget;
                                break;
                            } else {
                                $nextYear++;
                            }
                        } else {
                            break;
                        }
                    }
                    if (!$currentYearBudget && $nextYearBudget) {
                        $currentYearBudget = $nextYearBudget;
                        $nextYearBudget = null;
                    }
                }
                $requests = DB::table('medical_requests')
                    ->where('hospital', $hospital)
                    ->whereNotNull('amount')
                    ->select('firstname', 'middlename', 'lastname', 'diagnosis', 'amount', 'request')
                    ->get();
                $result[] = [
                    'hospital' => $hospital,
                    'current_year' => [
                        'total_budget' => $currentYearBudget->total_budget ?? null,
                        'budget_left' => $currentYearBudget->budget_left ?? null,
                        'total_expenses' => $currentYearBudget->total_expenses ?? 0,
                        'year' => $currentYearBudget->year ?? null,
                    ],
                    'next_year' => [
                        'total_budget' => optional($nextYearBudget)->total_budget,
                        'budget_left' => optional($nextYearBudget)->budget_left,
                        'total_expenses' => optional($nextYearBudget)->total_expenses ?? 0,
                        'year' => optional($nextYearBudget)->year,
                    ],
                    'requests' => $requests
                ];
            }
            return response()->json(['data' => $result], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
