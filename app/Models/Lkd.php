<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Lkd extends Model
{
    use HasFactory;

    protected $table = 'lkds';

    protected $fillable = [
        'judul',
        'slug',
        'excerpt',
        'body',
        'cover_path',    // path cover di disk 'public'
        'is_published',
        'order_no',
        'user_id',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'order_no'     => 'integer',
    ];

    /**
     * Gunakan slug untuk route model binding (detail publik).
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /* -----------------------------------------------------------------
     |  Relationships
     |------------------------------------------------------------------*/

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function members()
    {
        return $this->hasMany(LkdMember::class)->orderBy('order_no')->orderBy('id');
    }

    /* -----------------------------------------------------------------
     |  Scopes
     |------------------------------------------------------------------*/

    public function scopePublished($q)
    {
        return $q->where('is_published', true);
    }

    public function scopeOrdered($q)
    {
        return $q->orderBy('order_no')->orderByDesc('created_at');
    }

    /* -----------------------------------------------------------------
     |  Accessors
     |------------------------------------------------------------------*/

    /**
     * URL cover (seperti Berita::gambar menggunakan Storage::url).
     * - Jika cover_path ada & file eksis di disk 'public', pakai Storage::url
     * - Jika tidak, fallback ke placeholder
     */
    public function getCoverUrlAttribute(): string
    {
        $path = $this->cover_path;

        if ($path && Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->url($path);
        }

        // Fallback
        return '';
    }

    /**
     * Ringkas excerpt untuk list (opsional).
     */
    public function getExcerptShortAttribute(): string
    {
        return Str::limit(strip_tags((string)$this->excerpt ?: (string)$this->body), 160);
    }

    /* -----------------------------------------------------------------
     |  Helpers
     |------------------------------------------------------------------*/

    /**
     * Helper untuk membuat slug unik berdasarkan judul.
     */
    public static function makeUniqueSlug(string $judul): string
    {
        $base = Str::slug($judul);
        $slug = $base ?: Str::random(8);

        $i = 1;
        while (static::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }

    /**
     * Set slug jika kosong pada creating.
     */
    public static function booted(): void
    {
        static::creating(function (Lkd $model) {
            if (empty($model->slug) && !empty($model->judul)) {
                $model->slug = static::makeUniqueSlug($model->judul);
            }
        });

        /**
         * Saat menghapus LKD, hapus juga cover & foto-foto anggota di storage agar bersih.
         * (Meniru kedisiplinan pengelolaan file seperti di Berita).
         */
        static::deleting(function (Lkd $model) {
            // Hapus cover jika ada
            if ($model->cover_path && Storage::disk('public')->exists($model->cover_path)) {
                Storage::disk('public')->delete($model->cover_path);
            }

            // Hapus foto semua anggota (cascade on delete di DB sudah menghapus row; ini menghapus filenya)
            foreach ($model->members()->get(['foto_path']) as $m) {
                if ($m->foto_path && Storage::disk('public')->exists($m->foto_path)) {
                    Storage::disk('public')->delete($m->foto_path);
                }
            }
        });
    }
}
