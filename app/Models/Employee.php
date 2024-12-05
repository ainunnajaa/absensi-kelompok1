<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', // Nama karyawan
        'email', // Email karyawan
        'position', // Posisi karyawan
        'role', // Hak akses role (admin/user)
    ];

    // Relasi: Seorang karyawan dapat memiliki banyak data kehadiran
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
