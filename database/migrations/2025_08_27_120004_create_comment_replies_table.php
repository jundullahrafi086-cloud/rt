<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('comment_replies')) {
            Schema::create('comment_replies', function (Blueprint $table) {
                $table->id();
                $table->foreignId('comment_id')->constrained('comments')->cascadeOnDelete();
                $table->string('replyNama');
                $table->string('replyEmail');
                $table->text('replyBody');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('comment_replies');
    }
};
