<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Laravel\Sanctum\HasApiTokens; // Sesuaikan dengan trait yang Anda gunakan

class User extends Authenticatable
{
    // Hapus HasApiTokens jika Anda tidak menggunakannya
    use HasFactory, Notifiable; 

    // Definisikan Konstanta Peran
    const ROLE_SUPER_ADMIN = 1;
    const ROLE_QUALITY_CONTROL = 2; // QC
    const ROLE_OPERATOR = 3; // Operator

    /**
     * The attributes that are mass assignable.
     * HANYA 'name' (username), 'password', dan 'role' yang diizinkan
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email', // Dipertahankan di sini, tetapi akan diisi null di controller
        'password',
        'role', // PENTING
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Helper Methods untuk Cek Peran
    public function isSuperAdmin(): bool
    {
        return $this->role === self::ROLE_SUPER_ADMIN;
    }

    public function isQualityControl(): bool
    {
        return $this->role === self::ROLE_QUALITY_CONTROL;
    }

    public function isOperator(): bool
    {
        return $this->role === self::ROLE_OPERATOR;
    }
}