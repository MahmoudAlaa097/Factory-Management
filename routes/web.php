<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\FixingRequestController;
use App\Http\Controllers\LanguageController;


// Language Switching Routes
Route::get('lang/{lang}', [LanguageController::class, 'switch'])->name('switch-language');

// Authentication Routes
Route::get('/', [SessionController::class, 'create']);
Route::post('/login', [SessionController::class, 'store']);

// Dashboard Routes
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

