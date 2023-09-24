<?php

use App\Http\Controllers\Admin\SubCategoriesController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\CountriesController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\SubLocationController;
use App\Http\Controllers\Admin\VendorController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resources([
    'countries' => CountriesController::class,
    'category' => CategoriesController::class,
    'sub-category' => SubCategoriesController::class,
    'locations' => LocationController::class,
    'sub-locations' => SubLocationController::class,
]);

Route::get('/vendor/list', [VendorController::class, 'index'])->name('vendor.list');
Route::get('/vendor/approval', [VendorController::class, 'approve'])->name('vendor.approve');
Route::get('/vendor/approval/view/{id}', [VendorController::class, 'show'])->name('vendor.show');
Route::post('/vendor/approval/store', [VendorController::class, 'store'])->name('vendor.approve-store');



