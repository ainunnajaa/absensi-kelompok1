<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    // Dashboard untuk User
    public function dashboard()
    {
        return view('user.dashboard');
    }

    // User Presensi Masuk
    public function checkIn(Request $request)
    {
        $user = Auth::user();

        // Cek apakah user sudah melakukan presensi masuk hari ini
        $attendance = Attendance::where('user_id', $user->id)
            ->whereDate('date', now()->toDateString())
            ->first();

        if ($attendance) {
            return back()->with('error', 'You have already checked in today.');
        }

        // Simpan data presensi masuk
        Attendance::create([
            'user_id' => $user->id,
            'date' => now()->toDateString(),
            'check_in' => now()->toTimeString(),
        ]);

        return back()->with('success', 'You have successfully checked in.');
    }

    // User Presensi Pulang
    public function checkOut(Request $request)
    {
        $user = Auth::user();

        // Cari presensi hari ini
        $attendance = Attendance::where('user_id', $user->id)
            ->whereDate('date', now()->toDateString())
            ->first();

        if (!$attendance) {
            return back()->with('error', 'You have not checked in today.');
        }

        if ($attendance->check_out) {
            return back()->with('error', 'You have already checked out today.');
        }

        // Simpan waktu presensi pulang
        $attendance->update([
            'check_out' => now()->toTimeString(),
        ]);

        return back()->with('success', 'You have successfully checked out.');
    }

    // Rekap Kehadiran Bulanan User
    public function attendanceSummary()
    {
        $user = Auth::user();

        // Ambil data kehadiran untuk bulan ini
        $attendances = Attendance::where('user_id', $user->id)
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->get();

        return view('user.attendance.summary', compact('attendances'));
    }

    // Admin: Menampilkan semua data kehadiran
    public function index()
    {
        $attendances = Attendance::with('employee')->get(); // Eager loading untuk data employee
        return view('admin.attendance.index', compact('attendances'));
    }

    // Admin: Form Tambah Kehadiran
    public function create()
    {
        $employees = Employee::all(); // Data semua karyawan
        return view('admin.attendance.create', compact('employees'));
    }

    // Admin: Menyimpan Kehadiran Baru
    public function store(Request $request)
    {
        $request->validate([
            'status' => 'required|in:present,absent,late',
            'date' => 'required|date',
            'check_in' => 'required|date_format:H:i',
            'check_out' => 'nullable|date_format:H:i',
        ]);

        // Mendapatkan user yang sedang login
        $user = Auth::user();

        // Simpan data kehadiran baru
        Attendance::create([
            'employee_id' => $user->id, // Menggunakan ID karyawan yang sedang login
            'status' => $request->status,
            'date' => $request->date,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out, // check_out bisa null jika belum pulang
        ]);

        return redirect()->route('attendance.index')->with('success', 'Attendance added successfully');
    }

    // Admin: Update Kehadiran
    public function update(Request $request, Attendance $attendance)
    {
        $request->validate([
            'status' => 'required|in:present,absent,late',
        ]);

        $attendance->update($request->all());
        return redirect()->route('attendance.index')->with('success', 'Attendance updated successfully');
    }

    // Admin: Hapus Kehadiran
    public function destroy(Attendance $attendance)
    {
        $attendance->delete();
        return redirect()->route('attendance.index')->with('success', 'Attendance deleted successfully');
    }
}
