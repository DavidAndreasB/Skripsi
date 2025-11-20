<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spk extends Model // Pastikan S besar
{
    use HasFactory;

    protected $table = 'spks';
    protected $guarded = ['id'];

    public function items()
    {
        return $this->hasMany(SpkItem::class, 'spk_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function jobsheets()
    {
        return $this->hasMany(JobSheet::class, 'spk_id');
    }
}