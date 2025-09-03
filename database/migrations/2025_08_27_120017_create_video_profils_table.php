<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('video_profils')) {
            Schema::create('video_profils', function (Blueprint $table) {
                $table->id();
                $table->string('judul')->nullable();
                $table->string('url');
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('video_profils');
    }
};
