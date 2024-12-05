<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    /**
     * Admin: Menampilkan Semua Data Kehadiran
     */
    public function index()
    {
        // Mengambil data kehadiran dengan eager loading untuk menghindari query N+1
        $attendances = Attendance::with('employee')->get();

        return view('admin.attendance.index', compact('attendances'));
    }

    /**
     * Admin: Form Tambah Kehadiran
     */
    public function create()
    {
        // Cek apakah user adalah admin
        $user = Auth::user(); // Menggunakan guard default untuk mendapatkan user
        if (!$user || !$user->hasRole('admin')) { // Menggunakan metode hasRole pada model User
            return redirect()->route('login')->with('error', 'Access denied. Admins only.');
        }

        // Ambil semua data karyawan
        $employees = Employee::all();
        return view('admin.attendance.create', compact('employees'));
    }

    /**
     * Admin: Simpan Kehadiran Baru
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'status' => 'required|in:present,absent,late',
            'attendance_date' => 'required|date',
            'check_in' => 'nullable|date_format:H:i',
            'check_out' => 'nullable|date_format:H:i',
        ]);

        // Menyimpan data kehadiran baru
        Attendance::create([
            'employee_id' => $request->employee_id,
            'status' => $request->status,
            'attendance_date' => $request->attendance_date,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out, // Bisa kosong jika belum checkout
        ]);

        return redirect()->route('admin.attendance.index')->with('success', 'Attendance added successfully');
    }

    /**
     * Admin: Form Edit Kehadiran
     */
    public function edit(Attendance $attendance)
    {
        // Cek apakah user adalah admin
        $user = Auth::user(); // Menggunakan guard default untuk mendapatkan user
        if (!$user || !$user->hasRole('admin')) { // Menggunakan metode hasRole pada model User
            return redirect()->route('login')->with('error', 'Access denied. Admins only.');
        }

        // Ambil data karyawan
        $employees = Employee::all();
        return view('admin.attendance.edit', compact('attendance', 'employees'));
    }

    /**
     * Admin: Update Kehadiran
     */
    public function update(Request $request, Attendance $attendance)
    {
        // Validasi input dari form
        $request->validate([
            'status' => 'required|in:present,absent,late',
        ]);

        // Update data kehadiran
        $attendance->update($request->all());

        return redirect()->route('admin.attendance.index')->with('success', 'Attendance updated successfully');
    }

    /**
     * Admin: Hapus Kehadiran
     */
    public function destroy(Attendance $attendance)
    {
        // Hapus data kehadiran
        $attendance->delete();

        return redirect()->route('admin.attendance.index')->with('success', 'Attendance deleted successfully');
    }
}
