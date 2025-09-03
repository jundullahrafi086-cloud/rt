<?php

namespace App\Http\Controllers;

use App\Models\Anggaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnggaranController extends Controller
{
    public function index()
    {
        $items = Anggaran::latest()->paginate(12);
        return view('apbdesa.index', compact('items'));
    }

    public function detail(string $slug)
    {
        $anggaran = Anggaran::where('slug', $slug)->firstOrFail();
        return view('apbdesa.detail', compact('anggaran'));
    }

    // Buka (inline) di tab browser (PDF umumnya inline; file lain tergantung browser)
    public function open(string $slug)
    {
        $anggaran = Anggaran::where('slug', $slug)->firstOrFail();
        abort_unless($anggaran->dokumen_path && Storage::disk('public')->exists($anggaran->dokumen_path), 404);

        $path = storage_path('app/public/'.$anggaran->dokumen_path);
        $mime = $anggaran->dokumen_mime ?: 'application/octet-stream';

        return response()->file($path, ['Content-Type' => $mime]);
    }

    // Unduh file
    public function download(string $slug)
    {
        $anggaran = Anggaran::where('slug', $slug)->firstOrFail();
        abort_unless($anggaran->dokumen_path && Storage::disk('public')->exists($anggaran->dokumen_path), 404);

        $filename = $anggaran->dokumen_original ?: basename($anggaran->dokumen_path);
        return Storage::disk('public')->download($anggaran->dokumen_path, $filename);
    }
}
