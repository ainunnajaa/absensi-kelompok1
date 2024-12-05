<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::all(); // Ambil semua data karyawan
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
            'email' => 'required|email|unique:employees',
            // Validasi lainnya sesuai kebutuhan
        ]);

        Employee::create($request->all()); // Menyimpan data karyawan baru
        return redirect()->route('admin.employees.index');
    }

    public function edit(Employee $employee)
    {
        return view('admin.employees.edit', compact('employee'));
    }

    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,' . $employee->id,
            // Validasi lainnya sesuai kebutuhan
        ]);

        $employee->update($request->all()); // Mengupdate data karyawan
        return redirect()->route('admin.employees.index');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete(); // Menghapus data karyawan
        return redirect()->route('admin.employees.index');
    }
}
