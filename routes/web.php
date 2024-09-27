<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::post('/api/register', [AuthController::class, 'register']);



Route::get('/', [HomeController::class, 'index']);
Route::post('/api/login', [AuthController::class, 'login']);
/*Route::middleware('auth')->get('/dashboard', [DashboardController::class, 'index']);*/
