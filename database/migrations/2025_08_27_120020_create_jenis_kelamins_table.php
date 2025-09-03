<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('jenis_kelamins')) {
            Schema::create('jenis_kelamins', function (Blueprint $table) {
                $table->id();
                $table->string('nama')->unique();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('jenis_kelamins');
    }
};
