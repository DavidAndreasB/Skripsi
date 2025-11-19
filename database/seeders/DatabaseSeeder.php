<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Gunakan updateOrCreate untuk MEMASTIKAN akun superadmin ada
        User::updateOrCreate(
            [
                'username' => 'superadmin' // Menggunakan kolom yang BENAR
            ],
            [
                'password' => Hash::make('admin123'), // Password di-hash
                'role' => User::ROLE_SUPER_ADMIN, // Role 1 = Super Admin
            ]
        );

        // Tambahkan user QC dan Operator (opsional)
        User::updateOrCreate(
            ['username' => 'qc_user'],
            ['password' => Hash::make('password'), 'role' => User::ROLE_QUALITY_CONTROL]
        );
        User::updateOrCreate(
            ['username' => 'operator_user'],
            ['password' => Hash::make('password'), 'role' => User::ROLE_OPERATOR]
        );
    }
}