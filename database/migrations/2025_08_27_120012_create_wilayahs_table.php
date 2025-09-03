<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('wilayahs')) {
            Schema::create('wilayahs', function (Blueprint $table) {
                $table->id();
                $table->string('nama');
                $table->enum('jenis', ['dusun','rw','rt','kelurahan','desa','kecamatan','kabupaten','provinsi']);
                $table->string('kode')->nullable();
                $table->foreignId('parent_id')->nullable()->constrained('wilayahs')->nullOnDelete();
                $table->decimal('lat', 10, 7)->nullable();
                $table->decimal('lng', 10, 7)->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('wilayahs');
    }
};
