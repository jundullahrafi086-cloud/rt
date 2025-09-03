<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('sejarahs')) {
            Schema::create('sejarahs', function (Blueprint $table) {
                $table->id();
                $table->string('judul');
                $table->longText('isi')->nullable();
                $table->string('foto')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('sejarahs');
    }
};
