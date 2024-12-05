<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;

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

    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
    

});

// User Routes
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/dashboard', function () {
        return 'User Dashboard';
    })->name('user.dashboard');
 Route::middleware(['auth', 'role:user'])->group(function () {
        Route::get('/user/attendance', [AttendanceController::class, 'create'])->name('user.attendance');
        Route::post('/user/attendance', [AttendanceController::class, 'store'])->name('attendance.store');
    });
    Route::middleware(['auth', 'role:user'])->group(function () {
        Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
    });

    Route::middleware(['auth', 'role:user'])->group(function () {
        Route::get('/user/dashboard', [AttendanceController::class, 'dashboard'])->name('user.dashboard');
        Route::post('/user/attendance/check-in', [AttendanceController::class, 'checkIn'])->name('user.attendance.checkin');
        Route::post('/user/attendance/check-out', [AttendanceController::class, 'checkOut'])->name('user.attendance.checkout');
        Route::get('/user/attendance/summary', [AttendanceController::class, 'attendanceSummary'])->name('user.attendance.summary');
    });
    
     // Admin: Attendance CRUD Routes
     Route::get('/admin/attendance', [AttendanceController::class, 'index'])->name('admin.attendance.index'); // Display all attendance records
     Route::get('/admin/attendance/create', [AttendanceController::class, 'create'])->name('admin.attendance.create'); // Show form to add new attendance
     Route::post('/admin/attendance', [AttendanceController::class, 'store'])->name('admin.attendance.store'); // Store new attendance
     Route::get('/admin/attendance/{attendance}/edit', [AttendanceController::class, 'edit'])->name('admin.attendance.edit'); // Show form to edit attendance
     Route::put('/admin/attendance/{attendance}', [AttendanceController::class, 'update'])->name('admin.attendance.update'); // Update attendance data
     Route::delete('/admin/attendance/{attendance}', [AttendanceController::class, 'destroy'])->name('admin.attendance.destroy'); // Delete attendance
 });


