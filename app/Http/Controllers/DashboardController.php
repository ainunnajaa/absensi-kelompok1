<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Menampilkan Dashboard User
     */
    public function index()
{
    $user = Auth::user();  // Mendapatkan data pengguna yang sedang login
    $attendances = Attendance::where('user_id', $user->id)  // Ambil absensi untuk user yang sedang login
                              ->orderBy('tanggal_absen', 'desc')
                              ->get();

    // Mengecek apakah user sudah melakukan check-in hari ini
    $today = date('Y-m-d');
    $alreadyCheckedIn = Attendance::where('user_id', $user->id)
                                  ->where('tanggal_absen', $today)
                                  ->whereNotNull('check_in')
                                  ->exists();

    return view('user.dashboard', compact('attendances', 'alreadyCheckedIn'));
}


    /**
     * Melakukan Check-In
     */
    public function checkIn()
    {
        // Mengecek apakah karyawan sudah melakukan check-in hari ini
        $attendance = Attendance::where('employee_id', Auth::id())
            ->where('attendance_date', now()->toDateString())
            ->first();

        if ($attendance) {
            return redirect()->back()->with('error', 'Anda sudah melakukan check-in hari ini.');
        }

        // Membuat data absensi "Check-In"
        Attendance::create([
            'employee_id' => Auth::id(),
            'attendance_date' => now()->toDateString(),
            'status' => 'present', // Default status
            'check_in' => now()->toTimeString(), // Waktu check-in
        ]);

        return redirect()->back()->with('success', 'Check-in berhasil.');
    }

    /**
     * Melakukan Check-Out
     */
    public function checkOut()
    {
        // Mengecek apakah karyawan sudah melakukan check-in hari ini
        $attendance = Attendance::where('employee_id', Auth::id())
            ->where('attendance_date', now()->toDateString())
            ->first();

        if (!$attendance) {
            return redirect()->back()->with('error', 'Anda belum melakukan check-in hari ini.');
        }

        if ($attendance->check_out) {
            return redirect()->back()->with('error', 'Anda sudah melakukan check-out hari ini.');
        }

        // Memperbarui data absensi untuk "Check-Out"
        $attendance->update([
            'check_out' => now()->toTimeString(),
        ]);

        return redirect()->back()->with('success', 'Check-out berhasil.');
    }

    public function adminDashboard()
    {
        // Logika untuk dashboard admin, misalnya data semua attendance atau stats lainnya
        return view('admin.dashboard'); // Ganti sesuai dengan view admin
    }

    /**
     * Menampilkan Dashboard User
     */
    public function userDashboard()
    {
        // Mengambil data absensi untuk user
        $attendances = Attendance::where('employee_id', Auth::id())
            ->orderBy('attendance_date', 'desc')
            ->get();

        $alreadyCheckedIn = Attendance::where('employee_id', Auth::id())
            ->where('attendance_date', now()->toDateString())
            ->exists();

        // Perbaikan pada compact: pastikan formatnya benar
        return view('user.dashboard', ['attendances' => $attendances, 'alreadyCheckedIn' => $alreadyCheckedIn]);
    }

    /**
     * Menampilkan Dashboard Employee
     */
    public function employeeDashboard()
    {
        // Misalnya logika untuk employee
        return view('employee.dashboard'); // Ganti dengan view employee
    }
}
