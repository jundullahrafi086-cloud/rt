<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
       if (!Schema::hasColumn('beritas', 'gambar')) {
           Schema::table('beritas', function (Blueprint $table) {
               $table->string('gambar')->nullable()->after('slug');
           });
       }
       if (Schema::hasColumn('beritas', 'thumbnail') && Schema::hasColumn('beritas', 'gambar')) {
           DB::statement("UPDATE beritas SET gambar = COALESCE(gambar, thumbnail)");
       }
    }

    public function down(): void
    {
       if (Schema::hasColumn('beritas', 'gambar')) {
           Schema::table('beritas', function (Blueprint $table) {
               $table->dropColumn('gambar');
           });
       }
    }
};
