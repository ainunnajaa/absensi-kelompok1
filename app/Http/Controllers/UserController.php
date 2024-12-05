<?php

namespace App\Http\Controllers;

use App\Models\Attendance; // Model untuk absensi
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Menampilkan dashboard untuk user
    public function dashboard()
    {
        $user = Auth::user(); // Mendapatkan data user yang sedang login
        return view('user.dashboard', compact('user')); // Menampilkan dashboard untuk user
    }

    // Fitur absensi - check-in
    public function checkIn(Request $request)
    {
        $user = Auth::user(); // Mendapatkan data user yang sedang login

        // Periksa apakah sudah ada data absensi untuk hari ini
        $attendance = Attendance::where('user_id', $user->id)
            ->whereDate('created_at', now()->toDateString()) // Filter berdasarkan tanggal
            ->where('status', 'check-in')
            ->exists();

        if ($attendance) {
            return back()->with('error', 'You have already checked in today.');
        }

        // Simpan absensi check-in
        Attendance::create([
            'user_id' => $user->id,
            'status' => 'check-in',
            'time' => now(),
        ]);

        return back()->with('success', 'You have successfully checked in.');
    }

    // Fitur absensi - check-out
    public function checkOut(Request $request)
    {
        $user = Auth::user(); // Mendapatkan data user yang sedang login

        // Periksa apakah sudah ada data absensi check-in untuk hari ini
        $attendance = Attendance::where('user_id', $user->id)
            ->whereDate('created_at', now()->toDateString())
            ->where('status', 'check-in')
            ->first();

        if (!$attendance) {
            return back()->with('error', 'You must check-in before you can check-out.');
        }

        // Update absensi untuk check-out
        $attendance->update([
            'status' => 'check-out',
            'time' => now(),
        ]);

        return back()->with('success', 'You have successfully checked out.');
    }

    // Menampilkan ringkasan absensi bulanan
    public function attendanceSummary()
    {
        $user = Auth::user(); // Mendapatkan data user yang sedang login

        // Ambil data absensi untuk bulan ini
        $attendance = Attendance::where('user_id', $user->id)
            ->whereMonth('created_at', now()->month)
            ->get();

        return view('user.attendance-summary', compact('attendance'));
    }
}
