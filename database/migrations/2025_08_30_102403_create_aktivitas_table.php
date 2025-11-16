<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('aktivitas', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('no'); // Nomor SPK (contoh: VT.029.V.15.1)
            $table->string('nama_barang'); // Nama barang
            $table->text('rincian'); // Bisa pakai text biar lebih panjang
            $table->integer('quantity'); // Jumlah barang
            $table->date('tanggal'); // Tanggal aktivitas
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aktivitas');
    }
};
