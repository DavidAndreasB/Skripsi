<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Hapus pengguna yang ada (opsional, jika ingin mengulang data)
        // User::truncate(); 
        
        // Cek jika Super Admin belum ada untuk menghindari duplikasi
        if (!User::where('name', 'superadmin')->exists()) {
            User::create([
                'name' => 'superadmin', // Username untuk login
                'email' => null, // Dibuat NULL karena tidak digunakan
                'password' => Hash::make('admin123'), // Ganti dengan password kuat
                'role' => User::ROLE_SUPER_ADMIN, 
            ]);
        }
    }
}