<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCheckInAndCheckOutToAttendancesTable extends Migration
{
    public function up()
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->time('check_in')->nullable(); // Kolom untuk waktu absen masuk
            $table->time('check_out')->nullable(); // Kolom untuk waktu absen pulang
        });
    }

    public function down()
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropColumn(['check_in', 'check_out']); // Menghapus kolom jika migrasi dibatalkan
        });
    }
}
