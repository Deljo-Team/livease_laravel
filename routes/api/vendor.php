<?php

use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

Route::post('/register/vendor/category', [RegisterController::class, 'vendorCategory']);
Route::post('/register/vendor/details', [RegisterController::class, 'vendorCompanyDetails']);
Route::post('/register/vendor/address', [RegisterController::class, 'vendorCompanyAddress']);
Route::post('/register/vendor/logo', [RegisterController::class, 'vendorCompanyLogo']);
Route::post('/register', [RegisterController::class, 'index']);