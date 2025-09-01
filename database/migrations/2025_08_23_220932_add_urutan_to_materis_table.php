<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('materis', function (Blueprint $table) {
            // Tambahkan kolom 'urutan' setelah 'id_kurikulum'
            // Tipe integer, tidak boleh negatif, default 0
            $table->unsignedInteger('urutan')->default(0)->after('id_kurikulum');
        });
    }

    public function down(): void
    {
        Schema::table('materis', function (Blueprint $table) {
            $table->dropColumn('urutan');
        });
    }
};
