<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Hapus tabel lama agar bersih
        Schema::dropIfExists('spk_items');
        Schema::dropIfExists('spks');

        // 1. Tabel Header SPK (Menyimpan No & Tanggal)
        Schema::create('spks', function (Blueprint $table) {
            $table->id();
            $table->string('no_spk')->unique(); // Kolom 'No'
            $table->date('tanggal');             // Kolom 'Tanggal'
            $table->string('nama_pemesan');      // Tambahan: Agar tahu SPK untuk siapa
            $table->string('judul_proyek');      // Tambahan: Judul pekerjaan
            $table->enum('status', ['Draft', 'Diproses', 'Selesai'])->default('Diproses');
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->timestamps();
        });

        // 2. Tabel Item SPK (Menyimpan Nama Barang, Rincian, Quantity)
        Schema::create('spk_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('spk_id')->constrained('spks')->onDelete('cascade');
            
            $table->string('nama_barang'); // Kolom 'Nama Barang'
            $table->text('rincian');       // Kolom 'Rincian'
            $table->integer('quantity');   // Kolom 'Quantity' (Pengganti Volume)
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('spk_items');
        Schema::dropIfExists('spks');
    }
};