<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MedicalRequestController;
use Illuminate\Support\Facades\Auth;

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

Route::post('/logos', [LogoController::class, 'store']);
Route::get('/active-logos', [LogoController::class, 'displayImage']);


Route::prefix('medical-requests')->group(function () {
    Route::post('/request', [MedicalRequestController::class, 'store']);
    Route::get('/show/{id}', [MedicalRequestController::class, 'show']);
    Route::get('/get-all', [MedicalRequestController::class, 'index']);
    Route::put('/approve-amount/{id}', [MedicalRequestController::class, 'approve_amount']);
});
