<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\FixingRequestController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\FaultController;
use App\Http\Controllers\TestController;

// Language Switching Routes
Route::get('lang/{lang}', [LanguageController::class, 'switch'])->name('switch-language');

// Authentication Routes
Route::get('/', [SessionController::class, 'create'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [SessionController::class, 'store'])
    ->middleware('guest');

Route::post('/logout', [SessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

// Dashboard Routes
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

// Fault Routes
Route::middleware(['auth', 'permission:create-faults'])->group(function () {
    Route::get('/faults/create', [FaultController::class, 'create'])->name('fixing-request');
});

Route::get('/faults', [FaultController::class, 'index'])->name('faults.index');
