<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Gunakan ini untuk autentikasi
use Illuminate\Notifications\Notifiable;

class Employee extends Authenticatable
{
    use HasFactory, Notifiable; // Tambahkan Notifiable jika akan mengirim notifikasi

    /**
     * Atribut yang dapat diisi (fillable).
     */
    protected $fillable = [
        'name',       // Nama karyawan
        'email',      // Email karyawan
        'position',   // Posisi karyawan
        'role',       // Hak akses role (admin/user)
        'password',   // Password karyawan
    ];

    /**
     * Atribut yang harus disembunyikan saat serialisasi.
     */
    protected $hidden = [
        'password',   // Sembunyikan password
        'remember_token', // Jika menggunakan fitur remember me
    ];

    /**
     * Relasi: Seorang karyawan dapat memiliki banyak data kehadiran.
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
