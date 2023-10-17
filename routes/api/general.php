<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CountriesController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\SubCategoryController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


Route::post('/login', [LoginController::class, 'index']);
Route::post('/send-otp',[OtpController::class, 'sendOtp']);
Route::post('/verify-otp',[OtpController::class, 'verifyOtp']);
Route::get('/countries', [CountriesController::class, 'index']);
Route::get('/categories', [CategoryController::class, 'index']);
Route::post('/sub-category', [SubCategoryController::class, 'index'])->name('general.sub-category');
Route::post('/locations', [LocationController::class, 'index']);
Route::post('/sub-locations', [LocationController::class, 'viewSubLocations']);