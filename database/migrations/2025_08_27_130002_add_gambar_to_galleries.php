<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
       if (!Schema::hasColumn('galleries', 'gambar')) {
           Schema::table('galleries', function (Blueprint $table) {
               $table->string('gambar')->nullable()->after('title');
           });
       }
       if (Schema::hasColumn('galleries', 'path') && Schema::hasColumn('galleries', 'gambar')) {
           DB::statement("UPDATE galleries SET gambar = COALESCE(gambar, `path`)");
       }
    }

    public function down(): void
    {
       if (Schema::hasColumn('galleries', 'gambar')) {
           Schema::table('galleries', function (Blueprint $table) {
               $table->dropColumn('gambar');
           });
       }
    }
};
