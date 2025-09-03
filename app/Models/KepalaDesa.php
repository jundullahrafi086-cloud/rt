<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KepalaDesa extends Model
{
    protected $fillable = [
        'nama', 'periode_mulai', 'periode_selesai', 'foto', 'catatan', 'user_id'
    ];

    public function getPeriodeLabelAttribute(): string
    {
        $mulai = $this->periode_mulai ?: '?';
        $selesai = $this->periode_selesai ?: 'sekarang';
        return $mulai === $selesai ? (string)$mulai : "$mulai – $selesai";
    }
}
