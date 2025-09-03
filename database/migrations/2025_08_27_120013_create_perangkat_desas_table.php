<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('perangkat_desas')) {
            Schema::create('perangkat_desas', function (Blueprint $table) {
                $table->id();
                $table->string('nama');
                $table->string('jabatan');
                $table->string('foto')->nullable();
                $table->string('nik')->nullable();
                $table->date('tanggal_lahir')->nullable();
                $table->string('tempat_lahir')->nullable();
                $table->text('alamat')->nullable();
                $table->string('no_hp')->nullable();
                $table->string('email')->nullable();
                $table->date('periode_mulai')->nullable();
                $table->date('periode_selesai')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('perangkat_desas');
    }
};
