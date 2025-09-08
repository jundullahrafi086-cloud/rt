<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('anggarans', function (Blueprint $table) {
            $table->string('dokumen_path')->nullable();
            $table->string('dokumen_original')->nullable();
            $table->string('dokumen_mime')->nullable();
            $table->unsignedBigInteger('dokumen_size')->nullable();
        });
    }

    public function down(): void {
        Schema::table('anggarans', function (Blueprint $table) {
            $table->dropColumn(['dokumen_path', 'dokumen_original', 'dokumen_mime', 'dokumen_size']);
        });
    }
};
