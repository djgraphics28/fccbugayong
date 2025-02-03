<?php

use App\Livewire\Attendance;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/attendance', function () {
    return view('attendance');
})->name('attendance');

Route::get('/youthcamp-preregistration', function () {
    return view('registration');
})->name('youthcamp-preregistration');

Route::get('/lcr-preregistration', function () {
    return view('lcr-registration');
})->name('lcr-preregistration');

Route::get('/couples-preregistration', function () {
    return view('couples-registration');
})->name('couples-preregistration');
