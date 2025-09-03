<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggaran extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Helpers URL
    public function getDokumenUrlAttribute(): ?string
    {
        return $this->dokumen_path ? \Storage::url($this->dokumen_path) : null;
    }

    public function getGambarUrlAttribute(): ?string
    {
        return $this->gambar ? \Storage::url($this->gambar) : null;
    }
}
