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
use App\Http\Controllers\HospitalController;
use App\Http\Controllers\AdminDashboardController;

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

Route::prefix('dashboard')->group(function () {
 //admin
    Route::middleware(['admin'])->group(function () {
        Route::get('/get-hospital-count', [AdminDashboardController::class, 'getAllHospital']);

    });

});


Route::prefix('utility')->group(function () {

    Route::middleware(['admin'])->group(function () {
        //Educational Amount
        Route::get('/get-all-amount', [EducationalAssistanceController::class, 'index']);
        Route::post('/school-level-amount', [EducationalAssistanceController::class, 'add_educational_assistance_amount']);
        Route::put('/school-level-amount-change-status/{id}', [EducationalAssistanceController::class, 'educational_assistance_amount_change_status']);
        Route::put('/school-level-amount-update/{id}', [EducationalAssistanceController::class, 'educational_assistance_amount_update']);
        Route::delete('/school-level-amount-delte/{id}', [EducationalAssistanceController::class, 'deleteAmount']);
        //Website Logo
        Route::get('/get-logos', [LogoController::class, 'index']);
        Route::put('/active-logos/{id}', [LogoController::class, 'activeLogo']);
        Route::post('/add-logos', [LogoController::class, 'store']);
        Route::delete('/delete-logos/{id}', [LogoController::class, 'deleteLogo']);
        //Manage Hospitals
        Route::get('/get-hospitals', [HospitalController::class, 'index']);
        Route::delete('/delete-hospital/{id}', [HospitalController::class, 'delete_hospital']);
        Route::post('/save-hospital', [HospitalController::class, 'save_hospital']);
        Route::put('/active-hospital/{id}', [HospitalController::class, 'active_hospital']);
        Route::put('/edit-hospital/{id}', [HospitalController::class, 'edit_hospital']);
        Route::put('/deactivate-hospital/{id}', [HospitalController::class, 'deactivate_hospital']);
        //hospital offer
        Route::post('/create-hospital-offer/{id}', [HospitalController::class, 'createHospitalRequest']);
        Route::put('/active-offer/{id}', [HospitalController::class, 'active_offer']);
        Route::put('/edit-offer/{id}', [HospitalController::class, 'edit_offer']);
        Route::put('/deactivate-offer/{id}', [HospitalController::class, 'deactivate_offer']);
        Route::get('/get-hospital-service-offer/{id}', [HospitalController::class, 'getServiceOffersForHospital']);
        Route::delete('/delete-offer/{id}', [HospitalController::class, 'delete_offer']);
        Route::get('/get-hospital-with-offer', [HospitalController::class, 'hospitalsWithServiceOffers']);

    });

});
Route::prefix('educational-assistance')->group(function () {
    //no need authentication
    Route::post('/submit-educational-assistance-tulong-dunong', [EducationalAssistanceController::class, 'apply_educational_assistance_tulong_dunong']);
    Route::post('/submit-educational-assistance-smart-grant', [EducationalAssistanceController::class, 'apply_educational_assistance_smart_grant']);
    Route::post('/submit-educational-assistance', [EducationalAssistanceController::class, 'apply_educational_assistance']);
    Route::post('/check-application-status', [EducationalAssistanceController::class, 'check_educational_assistance_application_status']);
    //admin
    Route::middleware(['admin'])->group(function () {
        Route::get('/get-all-approved_shcolarship-request', [EducationalAssistanceController::class, 'get_all_approved_scholarship_request']);
        Route::get('/get-all-decline_shcolarship-request', [EducationalAssistanceController::class, 'get_all_decline_scholarship_request']);
        Route::get('/get-all-pending_shcolarship-request', [EducationalAssistanceController::class, 'get_all_pending_scholarship_request']);
        Route::get('/get-all-approved_shcolarship-request-tulong-dunong', [EducationalAssistanceController::class, 'get_all_approved_scholarship_request_tulong_dunong']);
        Route::get('/get-all-decline_shcolarship-request-tulong-dunong', [EducationalAssistanceController::class, 'get_all_decline_scholarship_request_tulong_dunong']);
        Route::get('/get-all-pending_shcolarship-request-tulong-dunong', [EducationalAssistanceController::class, 'get_all_pending_scholarship_request_tulong_dunong']);
        Route::get('/get-all-approved_shcolarship-request-smart-grant', [EducationalAssistanceController::class, 'get_all_approved_scholarship_request_smart_grant']);
        Route::get('/get-all-decline_shcolarship-request-smart-grant', [EducationalAssistanceController::class, 'get_all_decline_scholarship_request_smart_grant']);
        Route::get('/get-all-pending_shcolarship-request-smart-grant', [EducationalAssistanceController::class, 'get_all_pending_scholarship_request_smart_grant']);
        Route::put('/approve-scholarship-request/{id}', [EducationalAssistanceController::class, 'accept_educational_assistance']);
        Route::put('/decline-scholarship-request/{id}', [EducationalAssistanceController::class, 'decline_educational_assistance']);
        Route::post('/send-email-to-student/{id}', [EducationalAssistanceController::class, 'send_email_to_student']);
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
    Route::get('/get-hospital-and-offer', [MedicalRequestController::class, 'hospitalsWithServiceOffers']);

});
Route::post('/post-news', [NewsPortal::class, 'addNews']);
Route::prefix('dole')->group(function () {
    //no need authentication
    Route::post('/add-tupad', [DoleController::class, 'save_tupad']);
    Route::post('/code-checker', [DoleController::class, 'code_checker']);
    Route::post('/tupad-request-status-checker', [DoleController::class, 'tupad_request_status_checker']);
    //admin

    Route::middleware(['admin'])->group(function () {
        Route::get('/captain-list', [DoleController::class, 'captain_list']);
        Route::post('/give-slot/{id}', [DoleController::class, 'give_slot']);
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
