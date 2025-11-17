<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User; // Impor Model User untuk konstanta

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Pastikan kolom 'email' diizinkan untuk NULL, karena kita tidak menggunakannya
            // Jika kolom 'email' ada, ubah agar bisa menerima nilai NULL (opsional, tergantung setup awal Anda)
            // $table->string('email')->nullable()->change(); 
            
            // Tambahkan kolom 'role' (default Operator = 3)
            if (!Schema::hasColumn('users', 'role')) {
                $table->tinyInteger('role')->default(User::ROLE_OPERATOR)
                      ->after('name')
                      ->comment('1: Super Admin, 2: QC, 3: Operator');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }
        });
    }
};