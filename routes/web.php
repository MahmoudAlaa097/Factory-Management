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

Route::get('/tasks', [TaskController::class, 'index']);
Route::get('/tasks/create', [TaskController::class, 'create']);
Route::post('/tasks/store', [TaskController::class, 'store']);
Route::get('/tasks/{task}', [TaskController::class, 'show']);
Route::get('/tasks/{task}/base/edit', [TaskController::class, 'edit']);
Route::get('/tasks/{task}/maintenance/edit', [TaskController::class, 'edit']);
Route::patch('/tasks/{task}/base', [TaskController::class, 'update']);
Route::patch('/tasks/{task}/maintenance', [TaskController::class, 'update']);

Route::get('/fixing', [FixingRequestController::class, 'create']);

Route::get('/test', function () {
        return view('pages/login');
    });
