<?php

use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UniversityErpController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login.index');
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->group(function () {
    //sample dashboard

    Route::view('/sample-page', 'sample.samplePage')->name('sample.page');
});
Route::middleware(['role:Super Admin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('services.dashboard.index');
    })->name('dashboard');
    Route::resource('users', UserController::class);
    Route::resource('permissions', PermissionController::class);
    // Show assign form
    Route::get('roles/{role}/permissions', [RoleController::class, 'assignPermissions'])
        ->name('roles.permissions');

    // Update permissions
    Route::post('roles/{role}/permissions/update', [RoleController::class, 'updatePermissions'])
        ->name('roles.permissions.update');

    Route::resource('roles', RoleController::class);
    // Route::resource('university-erp', UniversityErpController::class);
    Route::resource('university-erp', UniversityErpController::class)
        ->except(['show']);
    Route::get('university-erp/search', [UniversityErpController::class, 'search'])->name('university-erp.search');

    // Route::get('services/{method}/{uni_id}', [ServiceController::class, 'handle']);
    // Route::get('services/students/{uni_id}', [ServiceController::class, 'students'])->name('services.students');
    Route::get('services/{method}/{uni_id}', [ServiceController::class, 'handle'])
        ->name('services.handle');
    // Route::get('/service/university', [ServiceController::class, 'handle']);
    Route::get('dashboards/{uni_id}', [ServiceController::class, 'dashboard'])->name('services.dashboard');
    Route::get('/services/students/{uni_id}', [ServiceController::class, 'students'])
    ->name('services.students');

});
