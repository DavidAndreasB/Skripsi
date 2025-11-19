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
            // 1. Tambahkan kolom email (nullable) jika belum ada
            if (!Schema::hasColumn('users', 'email')) {
                $table->string('email')->nullable()->after('username');
            }
            
            // 2. Tambahkan kolom role (default Operator = 3)
            if (!Schema::hasColumn('users', 'role')) {
                $table->tinyInteger('role')->default(User::ROLE_OPERATOR)
                      ->after('username')
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