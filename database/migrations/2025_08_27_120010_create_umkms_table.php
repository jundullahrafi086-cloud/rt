<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('umkms')) {
            Schema::create('umkms', function (Blueprint $table) {
                $table->id();
                $table->string('nama_usaha');
                $table->string('pemilik')->nullable();
                $table->string('kategori')->nullable();
                $table->string('alamat')->nullable();
                $table->string('telepon')->nullable();
                $table->string('email')->nullable();
                $table->string('website')->nullable();
                $table->text('deskripsi')->nullable();
                $table->string('foto')->nullable();
                $table->decimal('lat', 10, 7)->nullable();
                $table->decimal('lng', 10, 7)->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('umkms');
    }
};
