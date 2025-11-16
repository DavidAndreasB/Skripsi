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
    Schema::create('job_sheets', function (Blueprint $table) {
        $table->id();
        $table->string('no');                    // Nomor Job Sheet
        $table->string('nama_pekerjaan');        // Nama pekerjaan atau proyek
        $table->text('deskripsi');               // Rincian pekerjaan
        $table->decimal('tarif_per_jam', 10, 2); // Tarif per jam
        $table->integer('durasi_jam');           // Total jam kerja
        $table->decimal('total_harga', 12, 2);   // Hasil perhitungan otomatis
        $table->date('tanggal');                 // Tanggal pengerjaan
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_sheets');
    }
};
