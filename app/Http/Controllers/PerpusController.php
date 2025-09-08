<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class PerpusController extends Controller
{
    // List buku (judul + link) dengan pencarian
    public function index(Request $request)
    {
        $q = trim((string) $request->get('q', ''));

        $items = Buku::query()
            ->when($q !== '', function ($qq) use ($q) {
                $qq->where(function ($w) use ($q) {
                    $w->where('judul', 'like', '%'.$q.'%')
                      ->orWhere('deskripsi', 'like', '%'.$q.'%');
                });
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('perpus.index', compact('items', 'q'));
    }

    // (opsional) detail buku
    public function show(string $slug)
    {
        $buku = Buku::where('slug', $slug)->firstOrFail();
        return view('perpus.show', compact('buku'));
    }
}
