<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kepala_desas', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('periode_mulai', 10)->nullable(); // mis: 1998 / 01-1998
            $table->string('periode_selesai', 10)->nullable(); // mis: 2004 / 12-2004
            $table->string('foto')->nullable(); // path storage/app/public/kepala-desa/...
            $table->text('catatan')->nullable();
            if (Schema::hasTable('users')) {
                $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            }
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kepala_desas');
    }
};
