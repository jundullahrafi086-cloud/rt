<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('situs')) {
            Schema::create('situs', function (Blueprint $table) {
                $table->id();
                $table->string('nama_situs');
                $table->text('deskripsi')->nullable();
                $table->string('alamat')->nullable();
                $table->string('telepon')->nullable();
                $table->string('email')->nullable();
                $table->string('facebook')->nullable();
                $table->string('instagram')->nullable();
                $table->string('youtube')->nullable();
                $table->string('logo_path')->nullable();
                $table->string('favicon_path')->nullable();
                $table->decimal('lat', 10, 7)->nullable();
                $table->decimal('lng', 10, 7)->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('situs');
    }
};
