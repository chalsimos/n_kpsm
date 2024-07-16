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
use App\Http\Controllers\FileController;
use App\Http\Controllers\EducationalAssistanceController;
use App\Http\Controllers\HospitalController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\BudgetAllocation;
use App\Http\Controllers\CustomEmails;
use App\Http\Controllers\TupadHeader;


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
Route::post('/upload-file', [FileController::class, 'uploadFile']);

Route::post('/logos', [LogoController::class, 'store']);
Route::get('/active-logos', [LogoController::class, 'displayImage']);
Route::get('/news', [NewsPortal::class, 'index']);

Route::prefix('news-portal')->group(function () {
    // Route::middleware(['admin'])->group(function () {
        Route::get('/headline', [NewsPortal::class, 'getHeadLine']);
        Route::get('/featured-news', [NewsPortal::class, 'featuredNews']);
        Route::get('/featured-article', [NewsPortal::class, 'featuredArticle']);
        Route::get('/getMainArticle', [NewsPortal::class, 'getMainArticle']);
        Route::get('/getTrendingArticles', [NewsPortal::class, 'getTrendingArticles']);
        Route::get('/getArticle/{id}', [NewsPortal::class, 'getArticle']);
        Route::post('/articlecounter', [NewsPortal::class, 'articlecounter']);
        Route::get('/count-article-views/{articleId}', [NewsPortal::class, 'countArticleView']);
        Route::get('/most-viewed', [NewsPortal::class, 'getMostViewed']);
        Route::get('/news-all', [NewsPortal::class, 'displayAll']);
        Route::post('/news/{id}', [NewsPortal::class, 'update']);
        Route::get('/news-article', [NewsPortal::class, 'news_article']);
        Route::get('/news-events', [NewsPortal::class, 'news_events']);
        Route::get('/news-announcement', [NewsPortal::class, 'news_announcement']);
        Route::get('/news-updates', [NewsPortal::class, 'news_updates']);
        Route::get('/news-draft', [NewsPortal::class, 'news_draft']);
    // });
});

Route::prefix('budget')->group(function () {
    Route::middleware(['admin'])->group(function () {
        Route::post('/budget-allocations', [BudgetAllocation::class, 'save_budget_allocation']);
        Route::get('/budget-allocations', [BudgetAllocation::class, 'get_all_budget_allocations']);
        Route::get('/budget-allocations-hospital', [BudgetAllocation::class, 'get_unique_hospitals']);
    });
});

Route::prefix('dashboard')->group(function () {
    Route::middleware(['admin'])->group(function () {
        Route::get('/get-hospital-count', [AdminDashboardController::class, 'getAllHospital']);
        Route::get('/get-hospital-service-offer-count', [AdminDashboardController::class, 'getAllHospitalsWithServiceOffers']);
        Route::get('/municipality-barangay', [AdminDashboardController::class, 'getMunicipalityBarangayData']);
        Route::get('/educational-municipality-barangay', [AdminDashboardController::class, 'getMunicipalityBarangayEducationalData']);
        Route::get('/gender-medical-requests', [AdminDashboardController::class, 'getGenderMedicalRequest']);
        Route::get('/gender-educational-requests', [AdminDashboardController::class, 'getGenderEducationalRequest']);
        Route::get('/medical-requests-data', [AdminDashboardController::class, 'getMedicalRequestsData']);
        Route::get('/educational-requests-data', [AdminDashboardController::class, 'getEducationalRequestsData']);
        Route::get('/getData', [AdminDashboardController::class, 'getData']);
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
        //Custom Emails
        Route::post('/create-emails', [CustomEmails::class, 'storeEmail']);
        Route::put('/active-emails/{id}', [CustomEmails::class, 'activeEmail']);
        Route::put('/deactive-emails/{id}', [CustomEmails::class, 'deactivateEmail']);
        Route::delete('/delete-emails/{id}', [CustomEmails::class, 'deleteEmail']);
        Route::get('/get-emails', [CustomEmails::class, 'Emailindex']);
        Route::post('/send-emails/{id}', [CustomEmails::class, 'send_email']);
        //Tupad Header
        Route::post('/save-tupad-header', [TupadHeader::class, 'saveTupadExcelHeader']);
        Route::delete('/delete-tupad-header/{id}', [TupadHeader::class, 'deleteTupadExcelHeader']);
        Route::put('/update-tupad-header-status/{id}', [TupadHeader::class, 'toggleHeaderStatus']);
        Route::get('/get-tupad-header', [TupadHeader::class, 'getAllHeaders']);
    });
});
Route::prefix('educational-assistance')->group(function () {
    Route::post('/submit-educational-assistance-tulong-dunong', [EducationalAssistanceController::class, 'apply_educational_assistance_tulong_dunong']);
    Route::post('/submit-educational-assistance-smart-grant', [EducationalAssistanceController::class, 'apply_educational_assistance_smart_grant']);
    Route::post('/submit-educational-assistance', [EducationalAssistanceController::class, 'apply_educational_assistance']);
    Route::post('/check-application-status', [EducationalAssistanceController::class, 'check_educational_assistance_application_status']);
    Route::middleware(['admin'])->group(function () {
        Route::get('/requirements-path/{id}', [EducationalAssistanceController::class, 'requirementsPath']);
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
    Route::post('/request', [MedicalRequestController::class, 'store']);
    Route::middleware(['admin'])->group(function () {
        Route::get('/show/{id}', [MedicalRequestController::class, 'show']);
        Route::get('/requirements-path/{id}', [MedicalRequestController::class, 'requirementsPath']);
        Route::put('/decline/{id}', [MedicalRequestController::class, 'decline']);
        Route::get('/get-hospital-and-offer', [MedicalRequestController::class, 'hospitalsWithServiceOffers']);
        Route::put('/approve-amount/{id}', [MedicalRequestController::class, 'approve_amount']);
        Route::get('/get-all', [MedicalRequestController::class, 'index']);
        Route::get('/get-all-decline', [MedicalRequestController::class, 'Declineindex']);
        Route::get('/get-all-approve', [MedicalRequestController::class, 'Approveindex']);
        Route::get('/generate-all-approve', [MedicalRequestController::class, 'GenerateApprove']);
    });
});
Route::post('/post-news', [NewsPortal::class, 'addNews']);
Route::prefix('dole')->group(function () {
    Route::post('/add-tupad', [DoleController::class, 'save_tupad']);
    Route::post('/code-checker', [DoleController::class, 'code_checker']);
    Route::post('/tupad-request-status-checker', [DoleController::class, 'tupad_request_status_checker']);
    Route::middleware(['admin'])->group(function () {
        Route::get('/captain-list', [DoleController::class, 'captain_list']);
        Route::post('/give-slot/{id}', [DoleController::class, 'give_slot']);
        Route::get('/captain-list', [DoleController::class, 'captain_list']);
        Route::get('/getAll-captains-tupad-invites', [DoleController::class, 'getAll_captains_tupad_invites']);
        Route::get('/get-invites-per-captain', [DoleController::class, 'getTupadsPerCaptain']);
        Route::get('/all-captain-slot/{id}', [DoleController::class, 'allCaptain_tupadSlot']);
        Route::get('/get-file-path/{id}', [DoleController::class, 'getImagePaths']);
        Route::get('/get-excel-path/{id}', [DoleController::class, 'getExcelData']);
    });
    Route::middleware(['captain'])->group(function () {
        Route::get('/captain-slot-list', [DoleController::class, 'captain_tupad_slot']);
        Route::post('/generate-code', [DoleController::class, 'generateCodeAndSave']);
        Route::post('/generate-excel', [DoleController::class, 'generateExcel']);
        Route::get('/tupad-code-list', [DoleController::class, 'tupad_code_list']);
        Route::get('/captain-tupad-invited', [DoleController::class, 'captain_tupad_invite']);
        Route::put('/decline-tupad-request/{id}', [DoleController::class, 'decline_tupad_invites']);
        Route::put('/accept-tupad-request/{id}', [DoleController::class, 'accept_tupad_invites']);
        Route::post('/captain-upload-file', [DoleController::class, 'excel_upload_by_captain']);
        Route::post('/get-captain-slot', [DoleController::class, 'get_tupad_slot_count']);
        Route::get('/get-nocode-slot', [DoleController::class, 'getSlotsWithNoCode']);
        Route::post('/save-captain-tupad-member', [DoleController::class, 'save_tupad_by_captain']);
    });
    Route::get('/get-active-header', [TupadHeader::class, 'fetchActiveHeaders']);
});
