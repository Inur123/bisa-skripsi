<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Operator\OperatorController;
use App\Http\Controllers\Mahasiswa\MahasiswaController;
Auth::routes();

// Admin routes
Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});

// Operator routes
Route::middleware('auth')->group(function () {
    Route::get('/operator/dashboard', [OperatorController::class, 'dashboard'])->name('operator.dashboard');
});

// Mahasiswa routes
Route::middleware('auth')->group(function () {
    Route::get('/mahasiswa/dashboard', [MahasiswaController::class, 'dashboard'])->name('mahasiswa.dashboard');
});

