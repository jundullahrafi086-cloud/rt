<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LkdMember extends Model
{
    protected $table = 'lkd_members';

    protected $fillable = [
        'lkd_id','nama','jabatan','kategori','kontak',
        'foto_path','order_no','is_active',
    ];

    protected $casts = [
        'order_no'  => 'int',
        'is_active' => 'bool',
    ];

    /* =========================
     |  Relations
     * ========================= */
    public function lkd()
    {
        return $this->belongsTo(Lkd::class);
    }

    /* =========================
     |  Scopes
     * ========================= */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order_no');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /* =========================
     |  Accessors
     * ========================= */
    public function getFotoUrlAttribute(): string
    {
        $path = $this->foto_path;
        if ($path && Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->url($path);
        }
        return asset('images/placeholders/avatar.png');
    }

    /* =========================
     |  File helpers
     * ========================= */
    /**
     * Simpan file foto ke disk 'public' mengikuti pola Berita
     * dan kembalikan path relatifnya.
     */
    public static function storeUploadedPhoto(UploadedFile $file): string
    {
        $datePath = now()->format('Y/m/d');
        $dir      = "berita/lkd/members/{$datePath}";
        $name     = Str::random(40).'.'.$file->getClientOriginalExtension();

        return $file->storeAs($dir, $name, 'public');
    }

    /**
     * Ganti foto (hapus lama jika ada), set kolom foto_path, dan simpan model.
     */
    public function replacePhoto(UploadedFile $file): void
    {
        // hapus file lama
        if ($this->foto_path && Storage::disk('public')->exists($this->foto_path)) {
            Storage::disk('public')->delete($this->foto_path);
        }
        $this->foto_path = self::storeUploadedPhoto($file);
        $this->save();
    }

    /* =========================
     |  Model Events
     * ========================= */
    protected static function booted(): void
    {
        // Hapus file saat record dihapus
        static::deleting(function (LkdMember $model) {
            if ($model->foto_path && Storage::disk('public')->exists($model->foto_path)) {
                Storage::disk('public')->delete($model->foto_path);
            }
        });

        // Jika foto_path berubah saat update, hapus file lama
        static::updating(function (LkdMember $model) {
            if ($model->isDirty('foto_path')) {
                $original = $model->getOriginal('foto_path');
                if ($original && $original !== $model->foto_path && Storage::disk('public')->exists($original)) {
                    Storage::disk('public')->delete($original);
                }
            }
        });
    }
}
