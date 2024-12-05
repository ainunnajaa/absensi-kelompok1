<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AdminController;

// Route untuk login dan logout
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes
Route::middleware(['auth', 'role:admin'])->group(function () {

    // Dashboard
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // Employee Management (CRUD)
    Route::resource('employees', EmployeeController::class);

    // Attendance Management (CRUD)
    Route::resource('attendance', AttendanceController::class);

    // Rekapitulasi Kehadiran (View & Delete)
    Route::get('attendance-summary', [AttendanceController::class, 'summary'])->name('attendance.summary');
    Route::delete('attendance-summary/{id}', [AttendanceController::class, 'deleteSummary'])->name('attendance.summary.delete');
});

// User Routes
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/dashboard', function () {
        return 'User Dashboard';
    })->name('user.dashboard');
});

