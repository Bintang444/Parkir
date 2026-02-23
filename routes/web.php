<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\OwnerController;

// Redirect home ke login
Route::get('/', fn () => redirect('/login'));

// Authentication Routes
Route::get('/login', [AuthController::class, 'form'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Petugas Routes - Dashboard parkir & transaksi
Route::middleware(['auth', 'role:petugas'])
    ->prefix('petugas')
    ->group(function () {
        Route::get('/', [PetugasController::class, 'index']);
        Route::post('/checkin', [PetugasController::class, 'checkin']);
        Route::post('/checkout', [PetugasController::class, 'checkout']);
        Route::post('/selesai/{id}', [PetugasController::class, 'selesai']);
    });

// Owner Routes - Dashboard laporan & statistik
Route::middleware(['auth', 'role:owner'])
    ->prefix('owner')
    ->group(function () {
        Route::get('/', [OwnerController::class, 'dashboard']);
    });