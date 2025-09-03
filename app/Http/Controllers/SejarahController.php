<?php

namespace App\Http\Controllers;

use App\Models\Sejarah;
use App\Models\KepalaDesa;

class SejarahController extends Controller
{
    public function index()
    {
        $sejarah = Sejarah::latest()->first();

        // ambil daftar kepala desa per periode (jika tabel/model sudah ada)
        $kepalaDesas = class_exists(\App\Models\KepalaDesa::class)
            ? KepalaDesa::orderByDesc('periode_mulai')
                ->orderByDesc('periode_selesai')
                ->orderBy('nama')
                ->get()
            : collect(); // fallback biar tidak undefined kalau model belum dibuat

        return view('sejarah.index', compact('sejarah', 'kepalaDesas'));
    }
}
