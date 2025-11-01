<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\VisitorController;

Route::get('visitors', [VisitorController::class, 'index'])->name('visitors.index');
Route::post('visitors', [VisitorController::class, 'store'])->name('visitors.store');
Route::get('visitors/{visitor}', [VisitorController::class, 'show'])->name('visitors.show');
Route::put('visitors/{visitor}', [VisitorController::class, 'update'])->name('visitors.update');
Route::delete('visitors/{visitor}', [VisitorController::class, 'destroy'])->name('visitors.destroy');
Route::get('visitors/search/{name}', [VisitorController::class, 'search'])->name('visitors.search');
