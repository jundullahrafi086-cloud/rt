<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tujuan:
     * - Menyesuaikan tabel lkds (hapus kolom icon*, pastikan cover_path, excerpt, body, order_no, is_published).
     * - Membuat tabel lkd_members untuk data anggota per LKD (struktur/RT/RW/organisasi).
     */
    public function up(): void
    {
        // Pastikan tabel lkds sudah ada (sesuai project Anda).
        if (Schema::hasTable('lkds')) {
            Schema::table('lkds', function (Blueprint $table) {
                // Hapus kolom ikon bila ada (kita pindah konsep ke cover)
                if (Schema::hasColumn('lkds', 'icon')) {
                    $table->dropColumn('icon');
                }
                if (Schema::hasColumn('lkds', 'icon_color')) {
                    $table->dropColumn('icon_color');
                }

                // Tambahkan/cek kolom yang dibutuhkan
                if (!Schema::hasColumn('lkds', 'excerpt')) {
                    $table->string('excerpt', 255)->nullable()->after('slug');
                }
                if (!Schema::hasColumn('lkds', 'body')) {
                    $table->longText('body')->nullable()->after('excerpt');
                }
                if (!Schema::hasColumn('lkds', 'cover_path')) {
                    $table->string('cover_path', 255)->nullable()->after('body');
                }
                if (!Schema::hasColumn('lkds', 'is_published')) {
                    $table->boolean('is_published')->default(true)->after('cover_path');
                }
                if (!Schema::hasColumn('lkds', 'order_no')) {
                    $table->unsignedInteger('order_no')->default(0)->after('is_published');
                }
                if (!Schema::hasColumn('lkds', 'user_id')) {
                    $table->unsignedBigInteger('user_id')->nullable()->after('order_no');
                    $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
                }
            });
        }

        // Buat tabel anggota LKD
        if (!Schema::hasTable('lkd_members')) {
            Schema::create('lkd_members', function (Blueprint $table) {
                $table->id();

                $table->unsignedBigInteger('lkd_id');
                $table->foreign('lkd_id')->references('id')->on('lkds')->cascadeOnDelete();

                // Data anggota
                $table->string('nama', 150);
                $table->string('jabatan', 150)->nullable();         // contoh: Ketua RW 03, Ketua RT 01, Sekretaris, Bendahara, dsb
                $table->string('kategori', 100)->nullable();        // opsional: "struktur", "rt", "rw", "pkk", dll
                $table->string('kontak', 100)->nullable();          // no hp/email opsional
                $table->string('foto_path', 255)->nullable();       // penyimpanan foto anggota (public disk)

                // Pengurutan & publish
                $table->unsignedInteger('order_no')->default(0);
                $table->boolean('is_active')->default(true);

                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        // Hapus tabel anggota terlebih dulu (ada FK ke lkds)
        if (Schema::hasTable('lkd_members')) {
            Schema::dropIfExists('lkd_members');
        }

        // Kembalikan perubahan tabel lkds seminimal mungkin
        if (Schema::hasTable('lkds')) {
            Schema::table('lkds', function (Blueprint $table) {
                // Balikkan kolom ikon (opsional — jika ingin kembali ke versi lama)
                if (!Schema::hasColumn('lkds', 'icon')) {
                    $table->string('icon', 150)->nullable()->after('body');
                }
                if (!Schema::hasColumn('lkds', 'icon_color')) {
                    $table->string('icon_color', 30)->nullable()->after('icon');
                }

                // Kolom yang kita tambahkan tadi bisa di-drop bila diinginkan
                if (Schema::hasColumn('lkds', 'excerpt')) {
                    $table->dropColumn('excerpt');
                }
                if (Schema::hasColumn('lkds', 'body')) {
                    $table->dropColumn('body');
                }
                if (Schema::hasColumn('lkds', 'cover_path')) {
                    $table->dropColumn('cover_path');
                }
                if (Schema::hasColumn('lkds', 'is_published')) {
                    $table->dropColumn('is_published');
                }
                if (Schema::hasColumn('lkds', 'order_no')) {
                    $table->dropColumn('order_no');
                }

                // Drop FK user_id lalu kolomnya (hanya jika ada)
                if (Schema::hasColumn('lkds', 'user_id')) {
                    // Nama constraint bisa berbeda-beda; gunakan dropForeign jika ada
                    try {
                        $table->dropForeign(['user_id']);
                    } catch (\Throwable $e) {
                        // abaikan jika foreign tidak ada
                    }
                    $table->dropColumn('user_id');
                }
            });
        }
    }
};
