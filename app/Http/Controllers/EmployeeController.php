<?php

namespace App\Http\Controllers;

use App\Models\User; // Menggunakan model User, bukan Employee
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = User::all(); // Ambil semua data dari tabel users
        return view('admin.employees.index', compact('employees'));
    }

    public function create()
    {
        return view('admin.employees.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users', // Email harus unik di tabel users
            'password' => 'required|string|min:8',       // Password minimal 8 karakter
            'role' => 'required|in:admin,user',          // Role hanya bisa 'admin' atau 'user'
        ]);

        // Simpan data pengguna baru di tabel users
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Enkripsi password
            'role' => $request->role, // Simpan role yang dipilih
        ]);

        return redirect()->route('employees.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user) // Ganti Employee menjadi User
    {
        return view('admin.employees.edit', compact('user'));
    }

    public function update(Request $request, User $user) // Ganti Employee menjadi User
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id, // Pastikan email tetap unik
            'password' => 'nullable|string|min:8', // Password opsional saat update
            'role' => 'required|in:admin,user',
        ]);

        // Update data pengguna di tabel users
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password, // Update password jika ada
            'role' => $request->role,
        ]);

        return redirect()->route('employees.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user) // Ganti Employee menjadi User
    {
        $user->delete(); // Menghapus data pengguna
        return redirect()->route('employees.index')->with('success', 'User deleted successfully.');
    }
}

