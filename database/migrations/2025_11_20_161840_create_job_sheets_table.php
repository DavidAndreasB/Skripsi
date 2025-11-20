<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_sheets', function (Blueprint $table) {
            $table->id();
            // Relasi ke SPK (Induk Proyek)
            $table->foreignId('spk_id')->constrained('spks')->onDelete('cascade');
            
            // Relasi ke Operator (User yang mengerjakan)
            $table->foreignId('operator_id')->constrained('users'); 

            $table->date('tanggal');
            $table->string('jenis_pekerjaan'); // Milling, Bubut, dll
            
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->float('total_jam'); // Durasi dalam jam (desimal)
            
            $table->text('keterangan')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_sheets');
    }
};