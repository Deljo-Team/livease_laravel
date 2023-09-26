<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CountriesController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ServicemenController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\GenderController;
use App\Http\Controllers\VisaController;
use App\Http\Controllers\JobController;
use App\Models\Service;

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
// require __DIR__ . '/api/vendor.php';
// require __DIR__ . '/api/servicemen.php';
// require __DIR__ . '/api/general.php';

Route::post('/login', [LoginController::class, 'index']);
Route::post('/send-otp',[OtpController::class, 'sendOtp']);
Route::post('/verify-otp',[OtpController::class, 'verifyOtp']);
Route::get('/countries', [CountriesController::class, 'index']);
Route::get('/categories', [CategoryController::class, 'index']);
Route::post('/sub-category', [SubCategoryController::class, 'index']);
Route::post('/register/vendor/category', [RegisterController::class, 'vendorCategory']);
Route::post('/register/vendor/details', [RegisterController::class, 'vendorCompanyDetails']);
Route::post('/register/vendor/address', [RegisterController::class, 'vendorCompanyAddress']);
Route::post('/register/vendor/logo', [RegisterController::class, 'vendorCompanyLogo']);
Route::post('/register', [RegisterController::class, 'index']);

Route::post('/locations', [LocationController::class, 'index']);
Route::post('/sub-locations', [LocationController::class, 'viewSubLocations']);

Route::get('gender',[GenderController::class, 'index']);
Route::post('gender',[GenderController::class, 'storeOrUpdate']);
Route::delete('gender/{gender_id}',[GenderController::class, 'destroy']);

Route::get('visa',[VisaController::class, 'index']);
Route::post('visa',[VisaController::class, 'storeOrUpdate']);
Route::delete('visa/{visa_id}',[VisaController::class, 'destroy']);

Route::get('job',[JobController::class, 'index']);
Route::post('job',[JobController::class, 'storeOrUpdate']);
Route::delete('job/{job_id}',[JobController::class, 'destroy']);



Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/reset-password', [LoginController::class, 'resetPassword']);
    Route::get('/logout', [LoginController::class, 'logout'])->name('api.logout');

    Route::post('vendor/profile', [VendorController::class, 'index']);
    Route::post('vendor/profile/update', [VendorController::class, 'updateProfile']);

    Route::post('vendor/transactions/list', [TransactionController::class, 'index']);
    Route::post('vendor/transactions/store', [TransactionController::class, 'create']);
    // Route::get('vendor/transactions/{id}', [TransactionController::class, 'show']);
    // Route::put('vendor/transactions/{id}', [TransactionController::class, 'update']);
    Route::delete('vendor/transactions/{id}', [TransactionController::class, 'destroy']);

    Route::post('servicemen',[ServicemenController::class, 'index']);
    Route::post('servicemen/create',[ServicemenController::class, 'store']);
    Route::post('servicemen/edit',[ServicemenController::class, 'update']);
    Route::delete('servicemen/{id}', [ServicemenController::class, 'destroy']);

    Route::get('job-application',[JobApplicationController::class, 'index']);
    Route::post('job-application',[JobApplicationController::class, 'storeOrUpdate']);
    Route::delete('job-application/{job_application_id}',[JobApplicationController::class, 'destroy']);
    Route::post('vendor/job-application',[JobApplicationController::class, 'listJobApplications']);

    Route::get('nominee',[NomineeController::class, 'index']);
    Route::post('nominee',[NomineeController::class, 'storeOrUpdate']);
    Route::delete('nominee/{nominee_id}',[NomineeController::class, 'destroy']);
});