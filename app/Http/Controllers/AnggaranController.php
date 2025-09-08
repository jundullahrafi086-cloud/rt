<?php

namespace App\Http\Controllers;

use App\Models\Anggaran;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AnggaranController extends Controller
{
    /**
     * Halaman daftar APBDes (publik)
     * URL: /apbdesa
     */
    public function index()
    {
        // Pilih kolom yang diperlukan saja agar ringan
        $items = Anggaran::select('id','judul','slug','keterangan','gambar','dokumen_path','dokumen_original','created_at')
            ->orderByDesc('created_at')
            ->paginate(9);

        // Buat excerpt singkat dari keterangan untuk kartu
        $items->getCollection()->transform(function ($row) {
            $row->excerpt = Str::limit(trim(strip_tags($row->keterangan ?? '')), 140);
            return $row;
        });

        return view('apbdes.index', compact('items'));
    }

    /**
     * Halaman detail APBDes (publik)
     * URL: /apbdesa/{anggaran:slug}
     */
    public function detail(Anggaran $anggaran)
    {
        // Siapkan data pelengkap untuk tampilan
        $related = Anggaran::select('id','judul','slug','gambar','created_at')
            ->where('id', '!=', $anggaran->id)
            ->latest()
            ->limit(6)
            ->get();

        return view('apbdes.detail', compact('anggaran', 'related'));
    }
}
