<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Anggaran extends Model
{
    protected $table = 'anggarans';

    protected $fillable = [
        'judul',
        'slug',
        'keterangan',
        'gambar',             // path relatif di disk 'public', contoh: apbdes-covers/xxx.jpg
        'user_id',
        'dokumen_path',       // path relatif di disk 'public', contoh: apbdes/xxx.pdf
        'dokumen_original',
        'dokumen_mime',
        'dokumen_size',
    ];


    public function getGambarUrlAttribute(): ?string
    {
        if (!$this->gambar) return null;

        // URL penuh? kembalikan apa adanya
        if (preg_match('~^https?://~i', $this->gambar)) return $this->gambar;

        $rel = ltrim($this->gambar, '/');
        if (str_starts_with($rel, 'storage/')) $rel = substr($rel, 8);
        if (str_starts_with($rel, 'public/'))  $rel = substr($rel, 7);

        return Storage::disk('public')->exists($rel)
            ? Storage::disk('public')->url($rel)
            : null;
    }

    public function getDokumenUrlAttribute(): ?string
    {
        if (!$this->dokumen_path) return null;

        // URL penuh? kembalikan apa adanya
        if (preg_match('~^https?://~i', $this->dokumen_path)) return $this->dokumen_path;

        $rel = ltrim($this->dokumen_path, '/');
        if (str_starts_with($rel, 'storage/')) $rel = substr($rel, 8);
        if (str_starts_with($rel, 'public/'))  $rel = substr($rel, 7);

        return Storage::disk('public')->exists($rel)
            ? Storage::disk('public')->url($rel)
            : null;
    }

    /* ===========================
     * Auto-hapus file saat record dihapus
     * =========================== */

    protected static function booted(): void
    {
        static::deleting(function (self $m) {
            foreach (['dokumen_path', 'gambar'] as $col) {
                $raw = $m->{$col};
                if (!$raw || preg_match('~^https?://~i', $raw)) continue;

                $rel = ltrim($raw, '/');
                if (str_starts_with($rel, 'storage/')) $rel = substr($rel, 8);
                if (str_starts_with($rel, 'public/'))  $rel = substr($rel, 7);

                if ($rel && Storage::disk('public')->exists($rel)) {
                    Storage::disk('public')->delete($rel);
                }
            }
        });
    }
}
