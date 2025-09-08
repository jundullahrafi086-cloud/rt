<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Lkd extends Model
{
    protected $fillable = [
        'judul', 'deskripsi','slug', 'cover_path', 'published', 'created_by'
    ];

    protected $casts = [
        'published' => 'bool',
    ];

    /* Relations */
    public function members() {
        return $this->hasMany(LkdMember::class)->orderBy('order_no');
    }

    /* Accessors */
    public function getCoverUrlAttribute(): string {
        $path = $this->cover_path;
        if ($path && Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->url($path);
        }
        return asset('images/placeholders/cover.png');
    }
    public function scopePublished($query) {
        return $query->where('published', true);
    }
public function scopeOrdered($query) {
    return $query->orderBy('order_no');
}


    /* Events: hapus cover saat delete */
    protected static function booted(): void {
        static::deleting(function (Lkd $model) {
            if ($model->cover_path && Storage::disk('public')->exists($model->cover_path)) {
                Storage::disk('public')->delete($model->cover_path);
            }
        });
    }
}
