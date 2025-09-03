<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            if (!Schema::hasColumn('galleries','title')) {
                $table->string('title')->nullable()->after('id');
            }
            if (!Schema::hasColumn('galleries','description')) {
                $table->text('description')->nullable()->after('title');
            }
            if (!Schema::hasColumn('galleries','is_published')) {
                $table->boolean('is_published')->default(true)->after('description');
            }
            // Pastikan ada kolom file minimal salah satu
            if (!Schema::hasColumn('galleries','path') && !Schema::hasColumn('galleries','gambar') && !Schema::hasColumn('galleries','img')) {
                $table->string('path')->nullable()->after('is_published');
            }
            // Pastikan kolom relasi ada
            if (!Schema::hasColumn('galleries','group_id') && !Schema::hasColumn('galleries','album_id')) {
                $table->unsignedBigInteger('group_id')->nullable()->after('path');
            }
        });
    }

    public function down(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            if (Schema::hasColumn('galleries','title')) $table->dropColumn('title');
            if (Schema::hasColumn('galleries','description')) $table->dropColumn('description');
            if (Schema::hasColumn('galleries','is_published')) $table->dropColumn('is_published');
            // kolom path/relasi jangan di-drop kalau sudah dipakai
        });
    }
};
