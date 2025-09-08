<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class LkdMember extends Model
{
    use HasFactory;

    protected $table = 'lkd_members';

    protected $fillable = [
        'lkd_id',
        'nama',
        'jabatan',      // contoh: Ketua RW 03, Ketua RT 01, Sekretaris, Bendahara, dll
        'kategori',     // contoh: struktur, rt, rw, pkk, posyandu, lpm, dll (opsional)
        'kontak',       // no hp/email opsional
        'foto_path',    // path foto di disk 'public'
        'order_no',
        'is_active',
    ];

    protected $casts = [
        'order_no'  => 'integer',
        'is_active' => 'boolean',
    ];

    /* -----------------------------------------------------------------
     |  Relationships
     |------------------------------------------------------------------*/

    public function lkd()
    {
        return $this->belongsTo(Lkd::class);
    }

    /* -----------------------------------------------------------------
     |  Accessors
     |------------------------------------------------------------------*/

    /**
     * URL foto anggota.
     * - Jika foto_path ada & file eksis di disk 'public', pakai Storage::url
     * - Jika tidak, fallback ke avatar placeholder
     */
    public function getFotoUrlAttribute(): string
    {
        $path = $this->foto_path;

        if ($path && Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->url($path);
        }

        // Fallback avatar default
        return asset('images/placeholders/avatar.png');
    }

    /* -----------------------------------------------------------------
     |  Model Events
     |------------------------------------------------------------------*/

    /**
     * Saat menghapus anggota, hapus foto dari storage agar bersih.
     */
    protected static function booted(): void
    {
        static::deleting(function (LkdMember $model) {
            if ($model->foto_path && Storage::disk('public')->exists($model->foto_path)) {
                Storage::disk('public')->delete($model->foto_path);
            }
        });
    }
}
