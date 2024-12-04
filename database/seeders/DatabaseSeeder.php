<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // Tambahkan import ini
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Buat user dengan role admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'), // Hash password
            'role' => 'admin', // Role sebagai admin
        ]);

        // Buat user dengan role user
        User::create([
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => Hash::make('password'), // Hash password
            'role' => 'user', // Role sebagai user
        ]);
    }
}
