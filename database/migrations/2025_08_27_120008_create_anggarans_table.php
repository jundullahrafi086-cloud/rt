<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('anggarans')) {
            Schema::create('anggarans', function (Blueprint $table) {
                $table->id();
                $table->year('tahun');
                $table->enum('jenis', ['pendapatan', 'belanja']);
                $table->string('nama_kegiatan');
                $table->decimal('nominal', 18, 2)->default(0);
                $table->text('keterangan')->nullable();
                $table->string('dokumen_path')->nullable();
                $table->boolean('is_published')->default(true);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('anggarans');
    }
};
