<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class spk extends Model
{
    use HasFactory;

    protected $table = 'spk';

    protected $fillable = [
        'no',
        'nama_barang',
        'rincian',
        'quantity',
        'tanggal',
    ];
}
