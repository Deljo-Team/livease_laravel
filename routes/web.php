<?php

use App\Http\Controllers\Admin\SubCategoriesController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\CountriesController;
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

Route::get('/countries', [CountriesController::class, 'index'])->name('countries');
Route::get('/countries/create', [CountriesController::class, 'create'])->name('countries.create');
Route::post('/countries', [CountriesController::class, 'store'])->name('countries.store');
Route::get('/countries/{id}/edit', [CountriesController::class, 'edit'])->name('countries.edit');
Route::put('/countries/{id}', [CountriesController::class, 'update'])->name('countries.update');
Route::delete('/countries/{id}', [CountriesController::class, 'destroy'])->name('countries.destroy');

Route::get('/category', [CategoriesController::class, 'index'])->name('categories');
Route::get('/category/create', [CategoriesController::class, 'create'])->name('categories.create');
Route::post('/category', [CategoriesController::class, 'store'])->name('categories.store');
Route::get('/category/{id}/edit', [CategoriesController::class, 'edit'])->name('categories.edit');
Route::put('/category/{id}', [CategoriesController::class, 'update'])->name('categories.update');
Route::delete('/category/{id}', [CategoriesController::class, 'destroy'])->name('categories.destroy');

Route::get('/sub-category', [SubCategoriesController::class, 'index'])->name('sub_categories');
Route::get('/sub-category/create', [SubCategoriesController::class, 'create'])->name('sub_categories.create');
Route::post('/sub-category', [SubCategoriesController::class, 'store'])->name('sub_categories.store');
Route::get('/sub-category/{id}/edit', [SubCategoriesController::class, 'edit'])->name('sub_categories.edit');
Route::put('/sub-category/{id}', [SubCategoriesController::class, 'update'])->name('sub_categories.update');
Route::delete('/sub-category/{id}', [SubCategoriesController::class, 'destroy'])->name('sub_categories.destroy');

Route::get('/vendor/list', [VendorController::class, 'index'])->name('vendor.list');
Route::get('/vendor/approval', [VendorController::class, 'approve'])->name('vendor.approve');
Route::get('/vendor/approval/view/{id}', [VendorController::class, 'show'])->name('vendor.show');
Route::post('/vendor/approval/store', [VendorController::class, 'store'])->name('vendor.approve-store');
