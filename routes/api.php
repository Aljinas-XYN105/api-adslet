<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\TenantController;
use App\Http\Controllers\API\BranchController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\QuestionController;
use App\Http\Controllers\API\TerminalQuestionController;
use App\Http\Controllers\API\TerminalController;
use App\Http\Controllers\API\SMSController;
use App\Http\Controllers\API\SmsHistoryController;
use App\Http\Controllers\API\SmsCampaignController;
use App\Http\Controllers\API\SmsGroupController;
use App\Http\Controllers\API\SmsContactController;
use App\Http\Controllers\API\TenantSenderIDController;
use App\Http\Controllers\API\SmsCampignContactController;
use App\Http\Controllers\API\FeedbackGroupController;
use App\Http\Controllers\API\FeedbackQuestionController;
use App\Http\Controllers\API\FeedbackReportController;

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


Route::post('login', [AuthController::class, 'signin']);
Route::post('register', [AuthController::class, 'signup']);
Route::post('/send-sms', [SMSController::class, 'sendsms']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group( function () {
    Route::post('verify_token', [AuthController::class, 'verifyToken']);

    // Resouse API's
//     Route::resource('questions', QuestionController::class);
// Route::resource('branches', BranchController::class);
// Route::resource('tenants', TenantController::class);
// Route::resource('roles', RoleController::class);
// Route::resource('smshistory', SmsHistoryController::class);
// Route::resource('users', UserController::class);
// Route::resource('terminalquestions', TerminalQuestionController::class);
// Route::resource('terminals', TerminalController::class);
// Route::resource('smscampaigns', SmsCampaignController::class);
// //Route::resource('smscampaigns', SmsCampaignController::class);
// Route::resource('smsgroups', SmsGroupController::class);
   
});


Route::resource('questions', QuestionController::class);
Route::resource('branches', BranchController::class);
Route::resource('tenants', TenantController::class);
Route::resource('roles', RoleController::class);
Route::resource('smshistory', SmsHistoryController::class);
Route::resource('users', UserController::class);
Route::resource('terminalquestions', TerminalQuestionController::class);
Route::resource('terminals', TerminalController::class);
Route::resource('smscampaigns', SmsCampaignController::class);
Route::resource('smscontacts', SmsContactController::class);
Route::resource('smsgroups', SmsGroupController::class);
Route::resource('tenantsenderids', TenantSenderIDController::class);
Route::resource('smscampigncontacts', SmsCampignContactController::class);
Route::resource('feedbackgroups', FeedbackGroupController::class);
Route::resource('feedbackquestions', FeedbackQuestionController::class);
Route::resource('feedbackreports', FeedbackReportController::class);
