<?php
namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Mengambil data absensi berdasarkan user yang sedang login
        $attendances = Attendance::where('user_id', Auth::id())->orderBy('date', 'desc')->get();
        
        return view('user.dashboard', compact('attendances'));
    }

    public function checkIn()
    {
        $attendance = Attendance::where('user_id', Auth::id())->where('date', now()->toDateString())->first();

        if ($attendance) {
            return back()->with('error', 'You have already checked in today.');
        }

        // Membuat data absensi "Check In"
        Attendance::create([
            'user_id' => Auth::id(),
            'status' => 'Check In',
            'date' => now()->toDateString(),
        ]);

        return back()->with('success', 'Checked in successfully.');
    }

    public function checkOut()
    {
        $attendance = Attendance::where('user_id', Auth::id())->where('date', now()->toDateString())->first();

        if (!$attendance || $attendance->status == 'Check Out') {
            return back()->with('error', 'You have not checked in today.');
        }

        // Memperbarui data absensi "Check Out"
        $attendance->update([
            'status' => 'Check Out',
            'check_out' => now()->toTimeString(),
        ]);

        return back()->with('success', 'Checked out successfully.');
    }
}
