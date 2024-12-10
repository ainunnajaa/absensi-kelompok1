<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{

    use HasFactory;

    protected $fillable = [
        'judul_absensi',
        'check_in',
        'check_out',
        'tanggal_absen', // Update kolom yang diisi
    ];

    public $timestamps = false;
    // Relasi ke model Employee
    public function user()
    {
        return $this->belongsTo(User::class); // jika menggunakan user_id
    }

}
