<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spk extends Model
{
    use HasFactory;

    // Pastikan nama tabel benar (jamak)
    protected $table = 'spks'; 
    
    // Lindungi id, sisanya boleh diisi massal
    protected $guarded = ['id'];

    // ==========================================
    // RELASI KE ITEM (One-to-Many)
    // ==========================================
    public function items()
    {
        // Satu SPK memiliki banyak SpkItem
        return $this->hasMany(SpkItem::class, 'spk_id');
    }

    // ==========================================
    // RELASI KE USER PEMBUAT (Many-to-One)
    // ==========================================
    public function creator()
    {
        // Satu SPK "dimiliki" (dibuat) oleh satu User
        // 'created_by' adalah nama kolom foreign key di tabel spks
        return $this->belongsTo(User::class, 'created_by');
    }
}