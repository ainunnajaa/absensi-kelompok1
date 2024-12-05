<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    
    use HasFactory;

    protected $fillable = [
        'employee_id', 'status', 'attendance_date', 'check_in', 'check_out',
    ];

    // Relasi ke model Employee
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function hasRole($role)
    {
        return $this->role === $role; // Misalnya, peran disimpan di kolom `role`
    }
}
