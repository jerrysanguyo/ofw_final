<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Cms\CivilStatusController;
use App\Http\Controllers\Cms\EducationalAttainmentController;
use App\Http\Controllers\Cms\GenderController;
use App\Http\Controllers\Cms\ReligionController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login.index');
    Route::post('/login/authentication', [AuthController::class, 'authenticate'])->name('authenticate');
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::middleware('role:superadmin')
        ->prefix('sa')
        ->name('superadmin.')
        ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('gender', GenderController::class)->middleware('merge_cms:genders,gender');
        Route::resource('religion', ReligionController::class)->middleware('merge_cms:religions,religion');
        Route::resource('civil', CivilStatusController::class)->middleware('merge_cms:civil_statuses,civil');
        Route::resource('educational', EducationalAttainmentController::class)->middleware('merge_cms:educational_attainments,educational');
    });

    Route::middleware('role:admin')
        ->prefix('ad')
        ->name('admin.')
        ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('gender', GenderController::class)->middleware('merge_cms:genders,gender');
        Route::resource('religion', ReligionController::class)->middleware('merge_cms:religions,religion');
        Route::resource('civil', CivilStatusController::class)->middleware('merge_cms:civils,civil');
        Route::resource('educational', EducationalAttainmentController::class)->middleware('merge_cms:educational_attainments,educational');
    });

    Route::middleware('role:user')
        ->prefix('us')
        ->name('user.')
        ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    });
});