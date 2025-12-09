<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login.index');
});

Route::middleware(['auth:sanctum',config('jetstream.auth_session'),'verified',])->group(function () {
    //sample dashboard
    Route::get('/dashboard', function () {return view('dashboards.default-dashboard');})->name('dashboard');
    Route::view('/sample-page', 'sample.samplePage')->name('sample.page');
});
