<?php
// database/migrations/2025_09_02_000001_add_file_columns_to_anggarans_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('anggarans', function (Blueprint $table) {
            if (!Schema::hasColumn('anggarans', 'gambar')) $table->string('gambar')->nullable();
            if (!Schema::hasColumn('anggarans', 'dokumen_path')) $table->string('dokumen_path')->nullable();
            if (!Schema::hasColumn('anggarans', 'dokumen_original')) $table->string('dokumen_original')->nullable();
            if (!Schema::hasColumn('anggarans', 'dokumen_mime')) $table->string('dokumen_mime')->nullable();
            if (!Schema::hasColumn('anggarans', 'dokumen_size')) $table->unsignedBigInteger('dokumen_size')->nullable();
        });
    }

    public function down(): void {
        Schema::table('anggarans', function (Blueprint $table) {
            $table->dropColumn(['gambar','dokumen_path','dokumen_original','dokumen_mime','dokumen_size']);
        });
    }
};
