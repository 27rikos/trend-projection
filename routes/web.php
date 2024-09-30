<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SaleController;
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

Route::group(['middleware' => 'auth'], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('medicine', ObatController::class);
    Route::post('import-medicine', [ObatController::class, 'imports'])->name('import-medicine');
    Route::resource('sales', SaleController::class);
    Route::get('report', [ReportController::class, 'index'])->name('report');
});

Route::get('/', [LoginController::class, 'index'])->name('home')->middleware('guest');
Route::post('authentication', [LoginController::class, 'auth'])->name('auth')->middleware('guest');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');
