<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyAttendancesTable extends Migration
{
    /**
     * Menjalankan perubahan struktur tabel.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attendances', function (Blueprint $table) {
            // Menghapus kolom yang tidak dibutuhkan (misal: 'status' dan kolom lainnya)
            $table->dropColumn('status');

            // Menambahkan kolom 'judul_absensi' (varchar) untuk menyimpan judul absensi
            $table->string('judul_absensi')->nullable();

            // Menambah kolom 'check_in' dan 'check_out' dengan tipe 'time'
            $table->time('check_in')->nullable()->after('judul_absensi');
            $table->time('check_out')->nullable()->after('check_in');

            // Mengubah nama kolom 'attendance_date' menjadi 'tanggal_absen'
            $table->date('tanggal_absen')->change();
        });
    }

    /**
     * Membalikkan perubahan struktur tabel.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attendances', function (Blueprint $table) {
            // Mengembalikan perubahan tabel yang telah dilakukan di method 'up'
            $table->dropColumn('judul_absensi');
            $table->dropColumn('check_in');
            $table->dropColumn('check_out');
            $table->enum('status', ['present', 'absent', 'leave', 'holiday'])->default('present');
            $table->date('attendance_date')->change();
        });
    }
}
