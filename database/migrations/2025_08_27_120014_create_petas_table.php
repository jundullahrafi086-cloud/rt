<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('petas')) {
            Schema::create('petas', function (Blueprint $table) {
                $table->id();
                $table->string('nama');
                $table->text('deskripsi')->nullable();
                $table->enum('tipe', ['point','line','polygon'])->default('point');
                $table->string('warna')->nullable();
                $table->string('geojson_path')->nullable();
                $table->boolean('is_public')->default(true);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('petas');
    }
};
