<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::post('auth/register', [AuthController::class, 'register'])->name('register');
Route::get('auth/register', [AuthController::class, 'index'])->name('auth.register');
Route::get('auth/login', [AuthController::class, 'loginView'])->name('auth.login');
Route::post('auth/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
