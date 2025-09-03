<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
       if (!Schema::hasColumn('sliders', 'img_slider')) {
           Schema::table('sliders', function (Blueprint $table) {
               $table->string('img_slider')->nullable()->after('title');
           });
       }
       if (Schema::hasColumn('sliders', 'image_path') && Schema::hasColumn('sliders', 'img_slider')) {
           DB::statement("UPDATE sliders SET img_slider = COALESCE(img_slider, image_path)");
       }
    }

    public function down(): void
    {
       if (Schema::hasColumn('sliders', 'img_slider')) {
           Schema::table('sliders', function (Blueprint $table) {
               $table->dropColumn('img_slider');
           });
       }
    }
};
