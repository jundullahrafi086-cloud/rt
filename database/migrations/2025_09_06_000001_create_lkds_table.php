<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Buat tabel lkds (Lembaga Kemasyarakatan Desa).
     *
     * Kolom penting:
     * - judul, slug (unik untuk URL detail)
     * - excerpt (ringkasan singkat di listing)
     * - body (konten halaman detail)
     * - icon (class ikon, mis. "bi bi-folder-symlink")
     * - icon_color (hex/rgb, mis. "#ffbb2c")
     * - cover_path (opsional, gambar sampul)
     * - is_published (tampilkan/sembyikan di publik)
     * - order_no (urutan tampil)
     * - user_id (admin pembuat/pengubah)
     */
    public function up(): void
    {
        Schema::create('lkds', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('judul');
            $table->string('slug')->unique();

            $table->string('excerpt', 500)->nullable();
            $table->longText('body')->nullable();

            $table->string('icon')->default('bi bi-folder-symlink'); // class ikon Bootstrap Icons
            $table->string('icon_color', 32)->default('#5578ff');     // warna ikon (hex/rgb)

            $table->string('cover_path')->nullable();                 // storage path cover (opsional)

            $table->boolean('is_published')->default(true);
            $table->unsignedInteger('order_no')->default(0);

            $table->unsignedBigInteger('user_id')->nullable();        // admin yang mengelola
            $table->timestamps();

            // Jika ingin relasi ke users (nullable → set null saat user dihapus)
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lkds');
    }
};
