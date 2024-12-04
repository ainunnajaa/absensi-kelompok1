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
    // Admin Dashboard Route
     Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
});
Route::middleware(['auth', 'role:admin'])->group(function () {

    // CRUD Karyawan
    Route::resource('admin/employees', EmployeeController::class);
    
    // Rekapitulasi Kehadiran
    Route::get('admin/attendance', [AttendanceController::class, 'index'])->name('admin.attendance.index');
    Route::get('admin/attendance/{employee}', [AttendanceController::class, 'show'])->name('admin.attendance.show');
    Route::post('admin/attendance/{attendance}/update', [AttendanceController::class, 'update'])->name('admin.attendance.update');
    Route::delete('admin/attendance/{attendance}/delete', [AttendanceController::class, 'destroy'])->name('admin.attendance.destroy');
});

// User Routes
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/dashboard', function () {
        return 'User Dashboard';
    })->name('user.dashboard');
});
