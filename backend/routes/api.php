<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

//Controller
use App\Http\Controllers\LogoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MedicalRequestController;
use App\Http\Controllers\DoleController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/getuser', [AuthController::class, 'getUser']);
Route::get('/getUserType', [AuthController::class, 'getUserType']);

Route::post('/logos', [LogoController::class, 'store']);
Route::get('/active-logos', [LogoController::class, 'displayImage']);


Route::prefix('medical-requests')->group(function () {
    //client
    Route::post('/request', [MedicalRequestController::class, 'store']);
    //admin
    Route::get('/show/{id}', [MedicalRequestController::class, 'show']);
    Route::get('/get-all', [MedicalRequestController::class, 'index']);
    Route::put('/approve-amount/{id}', [MedicalRequestController::class, 'approve_amount']);
    Route::put('/decline/{id}', [MedicalRequestController::class, 'decline']);
});
Route::prefix('dole')->group(function () {
    Route::post('/code-checker', [DoleController::class, 'code_checker']);
    Route::post('/tupad-request-status-checker', [DoleController::class, 'tupad_request_status_checker']);
    //client
    Route::post('/add-tupad', [DoleController::class, 'save_tupad']);
    //admin
    Route::get('/captain-list', [DoleController::class, 'captain_list']);
    Route::post('/give-slot/{id}', [DoleController::class, 'give_slot']);
    Route::get('/getAll-captains-tupad-invites', [DoleController::class, 'getAll_captains_tupad_invites']);
    //captain
    Route::get('/captain-slot-list', [DoleController::class,'captain_tupad_slot']);
    Route::post('/generate-code', [DoleController::class,'generateCodeAndSave']);
    Route::get('/tupad-code-list', [DoleController::class,'tupad_code_list']);
    Route::get('/captain-tupad-invited', [DoleController::class,'captain_tupad_invite']);
    Route::put('/decline-tupad-request/{id}', [DoleController::class,'decline_tupad_invites']);
    Route::put('/accept-tupad-request/{id}', [DoleController::class,'accept_tupad_invites']);
});
