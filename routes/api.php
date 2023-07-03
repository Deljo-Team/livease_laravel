<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CountriesController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\RegisterController;

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


Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/register', [RegisterController::class, 'index']);
    Route::get('/logout', [LoginController::class, 'logout']);
    Route::get('/countries', [CountriesController::class, 'index']);
});