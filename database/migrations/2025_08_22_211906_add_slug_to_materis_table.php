<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('materis', function (Blueprint $table) {
            // Tambahkan kolom slug setelah kolom 'judul'
            // Unique() memastikan tidak ada slug yang sama
            $table->string('slug')->unique()->after('judul');
        });
    }

    public function down(): void
    {
        Schema::table('materis', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};
