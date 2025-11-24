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
Route::get('/', [SessionController::class, 'create']);
Route::post('/login', [SessionController::class, 'store']);

// Dashboard Routes
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Fault Routes
Route::get('/faults/create', [FaultController::class, 'create'])->name('fixing-request');

// AlpineJS Support Routes
// Route to return machines for a given division
Route::get('/machines/by-division', [FaultController::class, 'getMachinesByDivision'])
     ->name('machines.byDivision');

Route::get('/machines/by-division', [TestController::class, 'byDivision']);
