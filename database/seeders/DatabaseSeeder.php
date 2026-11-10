<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Akun Administrator Utama
        User::firstOrCreate(
            ['email' => 'admin@disdik.jambikota.go.id'],
            [
                'name' => 'Administrator Dinas Pendidikan',
                'role' => 'admin',
                'nip' => '19820315 200801 1 005',
                'jabatan' => 'Admin Sistem & Pelayanan',
                'password' => Hash::make('password'),
            ]
        );

        // 2. Akun Petugas Front Office
        User::firstOrCreate(
            ['email' => 'pelayanan@disdik.jambikota.go.id'],
            [
                'name' => 'Petugas Ruang Tamu Pelayanan (Magang)',
                'role' => 'petugas',
                'nip' => null,
                'jabatan' => 'Front Office Ruang Tamu Pelayanan',
                'password' => Hash::make('password'),
            ]
        );
    }
}
