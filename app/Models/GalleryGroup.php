<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class GalleryGroup extends Model
{
    protected $table = 'gallery_groups';

    protected $fillable = [
        'judul',
        'slug',
        'deskripsi',
        'cover', // DIUBAH dari 'cover_path'
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    public function photos()
    {
        return $this->hasMany(Gallery::class, 'group_id');
    }

    public function getCoverUrlAttribute(): string
    {
        // DIUBAH dari $this->cover_path
        if (!$this->cover) return asset('images/placeholder.png');
        return Storage::disk('public')->url($this->cover);
    }

    protected static function booted()
    {
        static::deleting(function (self $g) {
            // DIUBAH dari $g->cover_path
            if ($g->cover && Storage::disk('public')->exists($g->cover)) {
                Storage::disk('public')->delete($g->cover);
            }
            // cascade hapus foto
            foreach ($g->photos as $p) $p->delete();
        });
    }
}