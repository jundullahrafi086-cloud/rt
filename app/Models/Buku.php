<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $table = 'bukus';

    protected $fillable = [
        'judul',
        'slug',
        'deskripsi',
        'link_url',
        'user_id',
    ];

    // helper: tampilkan domain link untuk badge kecil
    public function getLinkDomainAttribute(): string
    {
        $host = parse_url($this->link_url ?? '', PHP_URL_HOST) ?: '';
        return strtolower($host);
    }
}
