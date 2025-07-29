<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\DashboardController;

Route::get('/', [SessionController::class, 'create']);
Route::post('/login', [SessionController::class, 'store']);

Route::get('/dashboard', [DashboardController::class, 'index']);
