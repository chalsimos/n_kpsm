<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

//Controller
use App\Http\Controllers\LogoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MedicalRequestController;
use App\Http\Controllers\DoleController;
use App\Http\Controllers\NewsPortal;
use App\Http\Controllers\EducationalAssistanceController;

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
Route::get('/active-logos', [LogoController::class, 'displayImage']);
Route::get('/news', [NewsPortal::class, 'index']);
Route::get('/headline', [NewsPortal::class, 'getHeadLine']);
Route::get('/featured-news', [NewsPortal::class, 'featuredNews']);
Route::get('/featured-article', [NewsPortal::class, 'featuredArticle']);

Route::prefix('utility')->group(function () {

    Route::middleware(['admin'])->group(function () {
        Route::get('/get-all-amount', [EducationalAssistanceController::class, 'index']);
        Route::post('/school-level-amount', [EducationalAssistanceController::class, 'add_educational_assistance_amount']);
        Route::put('/school-level-amount-change-status/{id}', [EducationalAssistanceController::class, 'educational_assistance_amount_change_status']);
        Route::put('/school-level-amount-update/{id}', [EducationalAssistanceController::class, 'educational_assistance_amount_update']);
        Route::delete('/school-level-amount-delte/{id}', [EducationalAssistanceController::class, 'deleteAmount']);

        Route::get('/get-logos', [LogoController::class, 'index']);
        Route::put('/active-logos/{id}', [LogoController::class, 'activeLogo']);
        Route::post('/add-logos', [LogoController::class, 'store']);
        Route::delete('/delete-logos/{id}', [LogoController::class, 'deleteLogo']);
    });
});
Route::prefix('educational-assistance')->group(function () {
    //no need authentication
    Route::post('/submit-educational-assistance', [EducationalAssistanceController::class, 'apply_educational_assistance']);
    Route::post('/confirm-code', [EducationalAssistanceController::class, 'confirm_code']);
    Route::post('/check-application-status', [EducationalAssistanceController::class, 'check_educational_assistance_application_status']);
    //admin
    Route::middleware(['admin'])->group(function () {
        Route::get('/get-all-approved_shcolarship-request', [EducationalAssistanceController::class, 'get_all_approved_scholarship_request']);
        Route::get('/get-all-decline_shcolarship-request', [EducationalAssistanceController::class, 'get_all_decline_scholarship_request']);
        Route::get('/get-all-pending_shcolarship-request', [EducationalAssistanceController::class, 'get_all_pending_scholarship_request']);
        Route::put('/approve-scholarship-request/{id}', [EducationalAssistanceController::class, 'accept_educational_assistance']);
        Route::put('/decline-scholarship-request/{id}', [EducationalAssistanceController::class, 'decline_educational_assistance']);
    });
});

Route::prefix('medical-requests')->group(function () {
    //no need authentication
    Route::post('/request', [MedicalRequestController::class, 'store']);
    //admin
    Route::middleware(['admin'])->group(function () {
        Route::get('/show/{id}', [MedicalRequestController::class, 'show']);
        Route::get('/requirements-path/{id}', [MedicalRequestController::class, 'requirementsPath']);
        Route::get('/get-all', [MedicalRequestController::class, 'index']);
        Route::put('/approve-amount/{id}', [MedicalRequestController::class, 'approve_amount']);
        Route::put('/decline/{id}', [MedicalRequestController::class, 'decline']);
    });
});
Route::post('/post-news', [NewsPortal::class, 'addNews']);
Route::prefix('dole')->group(function () {
    //no need authentication
    Route::post('/add-tupad', [DoleController::class, 'save_tupad']);
    Route::post('/code-checker', [DoleController::class, 'code_checker']);
    Route::post('/tupad-request-status-checker', [DoleController::class, 'tupad_request_status_checker']);
    //admin
    Route::get('/captain-list', [DoleController::class, 'captain_list']);

    Route::post('/give-slot/{id}', [DoleController::class, 'give_slot']);
    Route::middleware(['admin'])->group(function () {
        Route::get('/captain-list', [DoleController::class, 'captain_list']);
        Route::post('/give-slot/{id}', [DoleController::class, 'give_slot']);
        Route::get('/all-captain-slot/{id}', [DoleController::class, 'allCaptain_tupadSlot']);
        Route::get('/getAll-captains-tupad-invites', [DoleController::class, 'getAll_captains_tupad_invites']);
    });
    //captain
    Route::middleware(['captain'])->group(function () {
        Route::get('/captain-slot-list', [DoleController::class, 'captain_tupad_slot']);
        Route::post('/generate-code', [DoleController::class, 'generateCodeAndSave']);
        Route::get('/tupad-code-list', [DoleController::class, 'tupad_code_list']);
        Route::get('/captain-tupad-invited', [DoleController::class, 'captain_tupad_invite']);
        Route::put('/decline-tupad-request/{id}', [DoleController::class, 'decline_tupad_invites']);
        Route::put('/accept-tupad-request/{id}', [DoleController::class, 'accept_tupad_invites']);
    });
});
