<?php

// app/Http/Controllers/AttendanceController.php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    // Menampilkan semua data kehadiran
    public function index()
    {
        // Ambil data kehadiran semua karyawan
        $attendances = Attendance::with('employee')->get(); // Use eager loading to get employee data

        // Kirim data kehadiran ke view index
        return view('admin.attendance.index', compact('attendances'));
    }

    // Menyimpan data absensi baru
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'employee_id' => 'required|exists:employees,id', // Pastikan employee_id valid
            'status' => 'required|in:present,absent,late', // Status hanya bisa 'present', 'absent', atau 'late'
            'date' => 'required|date', // Validasi tanggal
        ]);

        // Menyimpan absensi baru
        Attendance::create([
            'employee_id' => $request->employee_id,
            'status' => $request->status,
            'date' => $request->date,
        ]);

        // Redirect ke halaman absensi setelah berhasil
        return redirect()->route('attendance.index')->with('success', 'Attendance added successfully');
    }

    // Menampilkan form untuk menambah absensi baru
    public function create()
    {
        // Mendapatkan semua data karyawan
        $employees = Employee::all();
        
        // Mengirim data karyawan ke view create
        return view('admin.attendance.create', compact('employees'));
    }

    // Mengupdate data absensi
    public function update(Request $request, Attendance $attendance)
    {
        // Update data absensi berdasarkan input
        $attendance->update($request->all());

        // Redirect ke halaman absensi setelah berhasil
        return redirect()->route('attendance.index');
    }

    // Menghapus data absensi
    public function destroy(Attendance $attendance)
    {
        // Menghapus data absensi
        $attendance->delete();

        // Redirect ke halaman absensi setelah berhasil
        return redirect()->route('attendance.index');
    }
}
