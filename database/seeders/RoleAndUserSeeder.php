<?php
// database/seeders/RoleAndUserSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleAndUserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Data Role
        $adminRole = Role::create(['name' => 'admin']);
        $guruRole = Role::create(['name' => 'guru']);
        $siswaRole = Role::create(['name' => 'siswa']);

        // 2. Buat Data User - ADMIN
        User::create([
            'role_id' => $adminRole->id,
            'nama' => 'Administrator Sistem',
            'username' => 'admin123',
            'email' => 'admin@lms.com',
            'password' => Hash::make('password123'), // Semua password diset: password123
        ]);

        // 3. Buat Data User - GURU
        User::create([
            'role_id' => $guruRole->id,
            'nama' => 'Budi Santoso, S.Pd',
            'username' => 'guru123',
            'email' => 'guru@lms.com',
            'password' => Hash::make('password123'),
        ]);

        // 4. Buat Data User - SISWA
        User::create([
            'role_id' => $siswaRole->id,
            'nama' => 'Andi Pratama',
            'username' => 'siswa123',
            'email' => 'siswa@lms.com',
            'password' => Hash::make('password123'),
        ]);
        User::create([
            'role_id' => $siswaRole->id,
            'nama' => 'Budi',
            'username' => 'budi',
            'email' => 'budi@lms.com',
            'password' => Hash::make('password123'),
        ]);
        User::create([
            'role_id' => $siswaRole->id,
            'nama' => 'Rudi',
            'username' => 'rudi',
            'email' => 'rudi@lms.com',
            'password' => Hash::make('password123'),
        ]);
    }
}