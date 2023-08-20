<?php

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
Route::get('/countries', [App\Http\Controllers\Admin\CountriesController::class, 'index'])->name('countries');
Route::get('/countries/create', [App\Http\Controllers\Admin\CountriesController::class, 'create'])->name('countries.create');
Route::post('/countries', [App\Http\Controllers\Admin\CountriesController::class, 'store'])->name('countries.store');
Route::get('/countries/{id}/edit', [App\Http\Controllers\Admin\CountriesController::class, 'edit'])->name('countries.edit');
Route::put('/countries/{id}', [App\Http\Controllers\Admin\CountriesController::class, 'update'])->name('countries.update');
Route::delete('/countries/{id}', [App\Http\Controllers\Admin\CountriesController::class, 'destroy'])->name('countries.destroy');