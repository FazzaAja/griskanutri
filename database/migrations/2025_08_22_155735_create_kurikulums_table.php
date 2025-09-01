<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kurikulums', function (Blueprint $table) {
            // Menggunakan 'id_kurikulum' sebagai primary key
            $table->bigIncrements('id_kurikulum');
            $table->string('nama');
            $table->text('keterangan')->nullable();
            $table->string('file')->nullable();
            $table->string('img')->nullable();
            // Mengganti created_at dan updated_at default
            $table->timestamp('upload_at')->nullable()->useCurrent();
            $table->timestamp('update_at')->nullable()->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kurikulums');
    }
};
