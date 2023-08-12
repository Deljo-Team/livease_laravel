<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CountriesController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ServicemenController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\TransactionController;
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
Route::post('/register/vendor/signature', [RegisterController::class, 'vendorCompanySignature']);
Route::post('/register', [RegisterController::class, 'index']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/reset-password', [LoginController::class, 'resetPassword']);
    Route::get('/logout', [LoginController::class, 'logout']);

    Route::post('vendor/transactions/list', [TransactionController::class, 'index']);
    Route::post('vendor/transactions/store', [TransactionController::class, 'create']);
    // Route::get('vendor/transactions/{id}', [TransactionController::class, 'show']);
    // Route::put('vendor/transactions/{id}', [TransactionController::class, 'update']);
    Route::delete('vendor/transactions/{id}', [TransactionController::class, 'destroy']);

    Route::post('servicemen',[ServicemenController::class, 'index']);
    Route::post('servicemen/create',[ServicemenController::class, 'store']);
    Route::post('servicemen/edit',[ServicemenController::class, 'update']);
    Route::delete('servicemen/{id}', [ServicemenController::class, 'destroy']);

});