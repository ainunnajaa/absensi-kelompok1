<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Employee;


class AdminController extends Controller
{
    /// Menampilkan dashboard admin
    public function index()
    {
        // Ambil data untuk ditampilkan di dashboard
        // Contoh data untuk rekapitulasi kehadiran
        $attendances = Attendance::all(); // Ambil data kehadiran semua karyawan
        $employees = Employee::all();     // Ambil data karyawan

        // Return tampilan dengan data
        return view('admin.dashboard', compact('attendances', 'employees'));
    }
}
