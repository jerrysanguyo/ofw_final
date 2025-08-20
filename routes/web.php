<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/login', [AuthController::class, 'authenticate'])->name('login.index');
Route::post('/login/authentication', [AuthController::class, 'authenticate'])->name('authenticate');