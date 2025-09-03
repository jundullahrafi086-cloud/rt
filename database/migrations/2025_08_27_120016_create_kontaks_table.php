<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('kontaks')) {
            Schema::create('kontaks', function (Blueprint $table) {
                $table->id();
                $table->string('nama');
                $table->string('email')->nullable();
                $table->string('subjek')->nullable();
                $table->text('pesan');
                $table->boolean('is_read')->default(false);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('kontaks');
    }
};
