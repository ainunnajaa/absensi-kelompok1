<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id', // ID karyawan yang hadir
        'date', // Tanggal kehadiran
        'status', // Status kehadiran: 'present', 'absent', atau 'late'
    ];

    // Relasi: Setiap data kehadiran berhubungan dengan satu karyawan
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
