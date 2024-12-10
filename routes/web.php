<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;

// Route untuk login dan logout
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rute untuk Admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // Rute Absensi Admin
    Route::get('/admin/attendance', [AttendanceController::class, 'index'])->name('admin.attendance.index');
    Route::get('/admin/attendance/create', [AttendanceController::class, 'create'])->name('admin.attendance.create');
    Route::post('/admin/attendance', [AttendanceController::class, 'store'])->name('admin.attendance.store');
    Route::get('/admin/attendance/{attendance}/edit', [AttendanceController::class, 'edit'])->name('admin.attendance.edit');
    Route::put('/admin/attendance/{attendance}', [AttendanceController::class, 'update'])->name('admin.attendance.update');
    Route::put('/attendance/{id}', [AttendanceController::class, 'update'])->name('admin.attendance.update');
    Route::delete('/admin/attendance/{attendance}', [AttendanceController::class, 'destroy'])->name('admin.attendance.destroy');
    
    // Rute Karyawan Admin
    Route::get('/admin/employees', [EmployeeController::class, 'index'])->name('employees.index');
    Route::get('/admin/employees/create', [EmployeeController::class, 'create'])->name('employees.create');
    Route::post('/admin/employees', [EmployeeController::class, 'store'])->name('employees.store');
    Route::get('/admin/employees/{employee}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
    Route::put('/admin/employees/{employee}', [EmployeeController::class, 'update'])->name('employees.update');
    Route::delete('/admin/employees/{employee}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
});


// Rute untuk User
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/dashboard', [DashboardController::class, 'index'])->name('user.dashboard');
    
    // Rute Absensi User
    Route::get('/user/attendance/create', [AttendanceController::class, 'create'])->name('user.attendance.create');  // Tambahkan rute ini
    Route::post('/user/attendance', [AttendanceController::class, 'store'])->name('user.attendance.store');
    Route::post('/user/attendance/check-in', [AttendanceController::class, 'checkIn'])->name('user.attendance.checkin');
    Route::post('/user/attendance/check-out', [AttendanceController::class, 'checkOut'])->name('user.attendance.checkout');
    
    // Rekapan Kehadiran User
    Route::get('/user/attendance/summary', [AttendanceController::class, 'attendanceSummary'])->name('user.attendance.summary');
    
    // Daftar Kehadiran User (Jika diperlukan)
    Route::get('/user/attendance', [AttendanceController::class, 'attendanceSummary'])->name('user.attendance.index');
});


