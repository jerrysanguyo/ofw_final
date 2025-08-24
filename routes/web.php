<?php

use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Cms\BarangayController;
use App\Http\Controllers\Cms\CivilStatusController;
use App\Http\Controllers\Cms\ContinentController;
use App\Http\Controllers\Cms\ContractController;
use App\Http\Controllers\Cms\CountryController;
use App\Http\Controllers\Cms\EducationalAttainmentController;
use App\Http\Controllers\Cms\GenderController;
use App\Http\Controllers\Cms\JobController;
use App\Http\Controllers\Cms\NeedController;
use App\Http\Controllers\Cms\OwwaController;
use App\Http\Controllers\Cms\RelationController;
use App\Http\Controllers\Cms\ReligionController;
use App\Http\Controllers\Cms\SubJobController;
use App\Http\Controllers\Cms\TypeIdController;
use App\Http\Controllers\Cms\TypeResidenceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FormController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login.index');
    Route::post('/login/authentication', [AuthController::class, 'authenticate'])->name('authenticate');
});

Route::get('/application-form/{uuid}', [FormController::class, 'index'])->name('form.index');
Route::get('/get-sub-jobs/{job}', [FormController::class, 'getByJob']);
Route::get('/get-countries/{continentId}', [FormController::class, 'getByContinent']);
Route::post('/application-form/{uuid}', [FormController::class, 'AppFormStore'])->name('form.store');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::middleware('role:superadmin')
        ->prefix('sa')
        ->name('superadmin.')
        ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('/dashboard/applicant-count', [DashboardController::class, 'applicantCount'])->name('dashboard.applicant.count');
        Route::post('/dashboard/continent-breakdown', [DashboardController::class, 'continentBreakdown'])->name('dashboard.continent.breakdown');
        Route::resource('gender', GenderController::class)->middleware('merge_cms:genders,gender');
        Route::resource('religion', ReligionController::class)->middleware('merge_cms:religions,religion');
        Route::resource('civil', CivilStatusController::class)->middleware('merge_cms:civil_statuses,civil');
        Route::resource('educational', EducationalAttainmentController::class)->middleware('merge_cms:educational_attainments,educational');
        Route::resource('barangay', BarangayController::class)->middleware('merge_cms:barangays,barangay');
        Route::resource('residence', TypeResidenceController::class)->middleware('merge_cms:type_residences,residence');
        Route::resource('typeId', TypeIdController::class)->middleware('merge_cms:type_ids,typeId');
        Route::resource('relation', RelationController::class)->middleware('merge_cms:relations,relation');
        Route::resource('owwa', OwwaController::class)->middleware('merge_cms:owwas,owwa');
        Route::resource('contract', ContractController::class)->middleware('merge_cms:contracts,contract');
        Route::resource('continent', ContinentController::class)->middleware('merge_cms:continents,continent');
        Route::resource('country', CountryController::class)->middleware('merge_cms:countries,country');
        Route::resource('job', JobController::class)->middleware('merge_cms:jobs,job');
        Route::resource('subJob', SubJobController::class)->middleware('merge_cms:sub_jobs,subJob');
        Route::resource('need', NeedController::class)->middleware('merge_cms:needs,need');
        Route::resource('applicant', ApplicantController::class);
    });

    Route::middleware('role:admin')
        ->prefix('ad')
        ->name('admin.')
        ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('/dashboard/applicant-count', [DashboardController::class, 'applicantCount'])->name('dashboard.applicant.count');
        Route::post('/dashboard/continent-breakdown', [DashboardController::class, 'continentBreakdown'])->name('dashboard.continent.breakdown');
        Route::resource('gender', GenderController::class)->middleware('merge_cms:genders,gender');
        Route::resource('religion', ReligionController::class)->middleware('merge_cms:religions,religion');
        Route::resource('civil', CivilStatusController::class)->middleware('merge_cms:civils,civil');
        Route::resource('educational', EducationalAttainmentController::class)->middleware('merge_cms:educational_attainments,educational');
        Route::resource('barangay', BarangayController::class)->middleware('merge_cms:barangays,barangay');
        Route::resource('residence', TypeResidenceController::class)->middleware('merge_cms:type_residences,residence');
        Route::resource('typeId', TypeIdController::class)->middleware('merge_cms:type_ids,typeId');
        Route::resource('relation', RelationController::class)->middleware('merge_cms:relations,relation');
        Route::resource('owwa', OwwaController::class)->middleware('merge_cms:owwas,owwa');
        Route::resource('contract', ContractController::class)->middleware('merge_cms:contracts,contract');
        Route::resource('country', CountryController::class)->middleware('merge_cms:countries,country');
        Route::resource('job', JobController::class)->middleware('merge_cms:jobs,job');
        Route::resource('subJob', SubJobController::class)->middleware('merge_cms:sub_jobs,subJob');
        Route::resource('need', NeedController::class)->middleware('merge_cms:needs,need');
    });

    Route::middleware('role:user')
        ->prefix('us')
        ->name('user.')
        ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    });
});