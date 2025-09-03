<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Gallery extends Model
{
    protected $table = 'galleries';

    protected $fillable = [
        'group_id',
        'title',
        'description',
        'is_published',
        // kolom file (legacy & baru)
        'path',
        'gambar',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    public function group()
    {
        return $this->belongsTo(GalleryGroup::class, 'group_id');
    }

    // URL gambar yang aman (pakai path dulu, lalu gambar)
    public function getImgUrlAttribute(): string
    {
        $file = $this->path ?? $this->gambar ?? null;
        if (!$file) {
            return asset('images/placeholder.png'); // optional placeholder
        }
        return Storage::disk('public')->url($file); // → /storage/...
    }

    protected static function booted()
    {
        static::deleting(function (self $g) {
            foreach (['path', 'gambar'] as $col) {
                if ($g->$col && Storage::disk('public')->exists($g->$col)) {
                    Storage::disk('public')->delete($g->$col);
                }
            }
        });
    }
}
