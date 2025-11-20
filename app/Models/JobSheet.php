<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobSheet extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // KONFIGURASI TARIF MESIN (Bisa diubah di sini)
    public const TARIF_MESIN = [
        'Milling' => 120000,
        'Bubut Kecil' => 120000,
        'Bubut Besar' => 250000,
        'Grinding' => 250000,
        'Las' => 200000,
        'Metal Spray' => 150000,
        'Sand Blasting / Pengecatan' => 200000,
    ];

    // Relasi ke SPK
    public function spk()
    {
        return $this->belongsTo(Spk::class, 'spk_id');
    }

    // Relasi ke Operator
    public function operator()
    {
        return $this->belongsTo(User::class, 'operator_id');
    }

    // Attribute Virtual: Menghitung Biaya (Total Jam * Tarif)
    public function getBiayaAttribute()
    {
        $tarif = self::TARIF_MESIN[$this->jenis_pekerjaan] ?? 0;
        return $tarif * $this->total_jam;
    }
}