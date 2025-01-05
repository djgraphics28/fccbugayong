<?php

use App\Livewire\Attendance;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/attendance', function() {
    return view('attendance');
})->name('attendance');
