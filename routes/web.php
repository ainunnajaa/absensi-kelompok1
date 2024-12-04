<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Route untuk login dan logout
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return 'Admin Dashboard';
    })->name('admin.dashboard');
});

// User Routes
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/dashboard', function () {
        return 'User Dashboard';
    })->name('user.dashboard');
});
