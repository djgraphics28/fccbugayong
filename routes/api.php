<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\VisitorController;
use App\Http\Controllers\API\PrayerRequestController;
use App\Http\Controllers\API\AuthController;

Route::get('visitors', [VisitorController::class, 'index'])->name('visitors.index');
Route::post('visitors', [VisitorController::class, 'store'])->name('visitors.store');
Route::get('visitors/{visitor}', [VisitorController::class, 'show'])->name('visitors.show');
Route::put('visitors/{visitor}', [VisitorController::class, 'update'])->name('visitors.update');
Route::delete('visitors/{visitor}', [VisitorController::class, 'destroy'])->name('visitors.destroy');
Route::get('visitors/search/{name}', [VisitorController::class, 'search'])->name('visitors.search');

Route::get('prayer-request', [PrayerRequestController::class, 'index'])->name('prayer-request.index');
Route::post('prayer-request', [PrayerRequestController::class, 'store'])->name('prayer-request.store');
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password');
Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout'])->name('logout');
