<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpkItem extends Model
{
    use HasFactory;

    protected $table = 'spk_items';
    // Izinkan pengisian massal untuk kolom-kolom ini
    protected $fillable = ['spk_id', 'nama_barang', 'rincian', 'quantity'];

    public function spk()
    {
        return $this->belongsTo(Spk::class, 'spk_id');
    }
}