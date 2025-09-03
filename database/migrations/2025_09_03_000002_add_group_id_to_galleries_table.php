<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            if (!Schema::hasColumn('galleries', 'group_id')) {
                $table->foreignId('group_id')
                      ->nullable()
                      ->constrained('gallery_groups') // tabel album
                      ->nullOnDelete()
                      ->after('id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            if (Schema::hasColumn('galleries', 'group_id')) {
                $table->dropConstrainedForeignId('group_id');
            }
        });
    }
};
