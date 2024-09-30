<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);
Route::post('/api/register', [AuthController::class, 'register']);
Route::post('/api/login', [AuthController::class, 'login']);
/*Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');*/
Route::get('/dashboard', function () {
    return view('dashboard'); })->name('dashboard');
