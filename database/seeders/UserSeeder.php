<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; // Pastikan memanggil Model User

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun ADMIN
        User::create([
            'username' => 'admin',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);

        // 2. Buat Akun PETUGAS
        User::create([
            'username' => 'petugas',
            'password' => bcrypt('password'),
            'role' => 'petugas'
        ]);

        // 3. Buat Akun OWNER (Ini yang tadi kurang)
        User::create([
            'username' => 'owner',
            'password' => bcrypt('password'),
            'role' => 'owner'
        ]);
    }
}