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
        // Mengambil data kehadiran dengan relasi karyawan untuk menghindari query N+1
        $attendances = Attendance::with('user')->orderBy('user_id', 'desc')->get();

        return view('admin.attendance.index', compact('attendances'));
    }

    /**
     * Admin: Form Tambah Kehadiran
     */
    public function create()
    {
        // Mengecek apakah user adalah admin
        $user = Auth::user();
        if (!$user || !$user->hasRole('admin')) {
            return redirect()->route('login')->with('error', 'Access denied. Admins only.');
        }

        // Mengambil data karyawan untuk dipilih saat input absensi
        $employees = Employee::all();
        return view('admin.attendance.create', compact('employees'));
    }

    /**
     * Admin: Simpan Kehadiran Baru
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'judul_absensi' => 'required|string',
            'tanggal_absen' => 'required|date',
            'check_in' => 'nullable|date_format:H:i',
            'check_out' => 'nullable|date_format:H:i',
        ]);

        // Menyimpan absensi baru
        Attendance::create([
            'judul_absensi' => $request->judul_absensi,
            'tanggal_absen' => $request->tanggal_absen,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
        ]);

        // Redirect ke halaman absensi dengan pesan sukses
        return redirect()->route('admin.attendance.index')->with('success', 'Attendance added successfully.');
    }

    /**
     * Admin: Form Edit Kehadiran
     */
    public function edit(Attendance $attendance)
    {
        // Mengecek apakah user adalah admin
        $user = Auth::user();
        if (!$user || !$user->hasRole('admin')) {
            return redirect()->route('login')->with('error', 'Access denied. Admins only.');
        }

        // Mengambil data karyawan untuk pilihan saat mengedit
        $employees = Employee::all();
        return view('admin.attendance.edit', compact('attendance', 'employees'));
    }

    /**
     * Admin: Update Kehadiran
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $validated = $request->validate([
            'judul_absensi' => 'required|string|max:255',
            'check_in' => 'required|date_format:H:i',
            'check_out' => 'required|date_format:H:i',
            'tanggal_absen' => 'required|date',
        ]);

        // Temukan attendance berdasarkan ID
        $attendance = Attendance::findOrFail($id);

        // Update attendance
        $attendance->judul_absensi = $validated['judul_absensi'];
        $attendance->check_in = $validated['check_in'];
        $attendance->check_out = $validated['check_out'];
        $attendance->tanggal_absen = $validated['tanggal_absen'];

        // Simpan perubahan
        $attendance->save();

        // Redirect dengan pesan sukses
        return redirect()->route('admin.attendance.index')->with('success', 'Attendance updated successfully!');
    }


    /**
     * Admin: Hapus Kehadiran
     */
    public function destroy(Attendance $attendance)
    {
        // Menghapus data absensi
        $attendance->delete();

        // Redirect ke halaman absensi dengan pesan sukses
        return redirect()->route('admin.attendance.index')->with('success', 'Attendance deleted successfully.');
    }

    /**
     * User: Menampilkan Form Absensi (Check-In & Check-Out)
     */
    public function showAttendanceForm()
    {
        // Mendapatkan data pengguna yang sedang login
        $user = Auth::user();
        $today = date('Y-m-d');

        // Mengecek apakah absensi sudah ada untuk hari ini
        $attendanceToday = Attendance::where('employee_id', $user->id)
            ->where('tanggal_absen', $today)
            ->first();

        $alreadyCheckedIn = $attendanceToday ? true : false;
        $alreadyCheckedOut = $attendanceToday && $attendanceToday->check_out ? true : false;

        return view('attendance.form', compact('alreadyCheckedIn', 'alreadyCheckedOut'));
    }

    /**
     * User: Proses Check-In
     */
    public function checkIn(Request $request)
    {
        $user = Auth::user();  // Ambil data user yang sedang login
        $today = date('Y-m-d'); // Tanggal hari ini

        // Cari absensi untuk hari ini
        $attendance = Attendance::where('user_id', $user->id)
            ->where('tanggal_absen', $today)
            ->first();

        // Jika absensi belum ada, buat absensi baru
        if (!$attendance) {
            $attendance = new Attendance();
            $attendance->user_id = $user->id; // Set user_id
            $attendance->tanggal_absen = $today;
            $attendance->judul_absensi = 'Absensi Karyawan'; // Nilai default untuk judul_absensi
            $attendance->check_in = now(); // Waktu check-in sekarang
            $attendance->save();
        }

        return redirect()->route('user.dashboard')->with('success', 'Check-in berhasil!');
    }


    public function checkOut(Request $request)
    {
        $user = Auth::user();  // Mendapatkan pengguna yang sedang login
        $today = date('Y-m-d'); // Tanggal hari ini

        // Menemukan absensi untuk hari ini
        $attendance = Attendance::where('tanggal_absen', $today)
            ->where('user_id', $user->id)  // Menghubungkan absensi dengan user
            ->first();

        if (!$attendance) {
            return back()->with('error', 'You have not checked in today.');
        }

        // Melakukan update waktu check-out
        $attendance->update([
            'check_out' => now()->toTimeString(),
        ]);

        return back()->with('success', 'Check-out successful.');
    }


    /**
     * User: Menampilkan Rekapan Kehadiran
     */
    public function attendanceSummary()
    {
        $user = Auth::user();

        // Mengambil data absensi pengguna dengan urutan terbaru
        $attendances = Attendance::where('employee_id', $user->id)
            ->orderBy('tanggal_absen', 'desc')
            ->get();

        return view('attendance.summary', compact('attendances'));
    }
}
