<?php

namespace App\Http\Controllers;

use App\Models\TupadExcelHeader;
use App\Models\TupadSlot;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;

class TupadHeader extends Controller
{
    public function getAllHeaders(Request $request)
    {
        try {
            $headers = TupadExcelHeader::all();
            return response()->json($headers, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function saveTupadExcelHeader(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'header' => 'required|unique:tupad_excel_headers,header',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        try {
            $nonCaptainDataExists = TupadSlot::where('status', '!=', 'Data Save by Captain')->exists();
            if ($nonCaptainDataExists) {
                return response()->json(['error' => 'Cannot add new header while there are still tupad form that is not submitted by the captain"'], 400);
            }
            $header = $request->input('header');
            $key = strtolower($header);
            $status = 'active';
            $newHeader = new TupadExcelHeader();
            $newHeader->header = $header;
            $newHeader->key = $key;
            $newHeader->status = $status;
            $newHeader->save();
            $table = 'tupads';
            $columnExists = Schema::hasColumn($table, $key);
            if (!$columnExists) {
                Schema::table($table, function (Blueprint $table) use ($key) {
                    $table->string($key)->nullable();
                });
            }
            return response()->json(['message' => 'TupadExcelHeader saved successfully'], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function fetchActiveHeaders()
    {
        try {
            $activeHeaders = TupadExcelHeader::where('status', 'active')->get(['header', 'key']);
            return response()->json(['headers' => $activeHeaders], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function deleteTupadExcelHeader(Request $request, $id)
    {
        try {
            $header = TupadExcelHeader::find($id);
            if (!$header) {
                return response()->json(['error' => 'TupadExcelHeader not found'], 404);
            }
            $nonCaptainDataExists = TupadSlot::where('status', '!=', 'Data Save by Captain')->exists();
            if ($nonCaptainDataExists) {
                return response()->json(['error' => 'Cannot add delete header while there are still tupad form that is not submitted by the captain"'], 400);
            }
            $protectedHeaders = ['province', 'municipality', 'barangay'];
            if (in_array(strtolower($header->header), $protectedHeaders)) {
                return response()->json(['error' => 'Cannot delete protected header'], 400);
            }
            $key = strtolower($header->header);
            Schema::table('tupads', function (Blueprint $table) use ($key) {
                $table->dropColumn($key);
            });
            $header->delete();
            return response()->json(['message' => 'TupadExcelHeader deleted successfully'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function toggleHeaderStatus(string $id)
    {
        try {
            $TupadHeader = TupadExcelHeader::findOrFail($id);
            if (!$TupadHeader) {
                return response()->json(['error' => 'Tupad Excel Header not found'], 404);
            }
            $nonCaptainDataExists = TupadSlot::where('status', '!=', 'Data Save by Captain')->exists();
            if ($nonCaptainDataExists) {
                return response()->json(['error' => 'Cannot add deactivate header while there are still tupad form that is not submitted by the captain"'], 400);
            }
            $protectedHeaders = ['province', 'municipality', 'barangay', 'gender', 'age', 'birthday', 'sex'];
            if (in_array(strtolower($TupadHeader->header), $protectedHeaders)) {
                return response()->json(['error' => 'Cannot deactivate protected header'], 400);
            }
            $key = strtolower($TupadHeader->header);
            if ($TupadHeader->status === 'active') {
                $TupadHeader->status = 'inactive';
                Schema::table('tupads', function (Blueprint $table) use ($key) {
                    $table->dropColumn($key);
                });
            } else {
                $TupadHeader->status = 'active';
                Schema::table('tupads', function (Blueprint $table) use ($key) {
                    $table->string($key)->nullable();
                });
            }
            $TupadHeader->save();
            return response()->json(['message' => 'Tupad Header status updated successfully'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
