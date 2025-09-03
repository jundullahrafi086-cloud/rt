<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('beritas')) {
            Schema::create('beritas', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
                $table->foreignId('kategori_id')->nullable()->constrained('kategoris')->nullOnDelete();
                $table->foreignId('post_status_id')->nullable()->constrained('post_statuses')->nullOnDelete();
                $table->string('judul');
                $table->string('slug')->unique();
                $table->string('thumbnail')->nullable();
                $table->string('excerpt', 500)->nullable();
                $table->longText('isi')->nullable();
                $table->unsignedBigInteger('views')->default(0);
                $table->timestamp('published_at')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('beritas');
    }
};
