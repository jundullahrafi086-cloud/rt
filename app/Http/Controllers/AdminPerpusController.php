<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminPerpusController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->get('q', ''));
        $items = Buku::query()
            ->when($q !== '', function ($qq) use ($q) {
                $qq->where(function ($w) use ($q) {
                    $w->where('judul', 'like', '%'.$q.'%')
                      ->orWhere('deskripsi', 'like', '%'.$q.'%')
                      ->orWhere('link_url', 'like', '%'.$q.'%');
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.perpus.index', compact('items', 'q'));
    }

    public function create()
    {
        return view('admin.perpus.create');
    }

    public function store(Request $request)
    {
        // slug otomatis jika kosong
        $slug = $request->input('slug') ?: Str::slug((string)$request->input('judul'));
        $request->merge(['slug' => $slug]);

        $validated = $request->validate([
            'judul'     => 'required|string|max:255',
            'slug'      => 'required|string|max:255|unique:bukus,slug',
            'link_url'  => 'required|url|max:2048',
            'deskripsi' => 'nullable|string',
        ], [
            'judul.required'    => 'Judul buku wajib diisi.',
            'slug.required'     => 'Slug wajib diisi.',
            'slug.unique'       => 'Slug sudah dipakai.',
            'link_url.required' => 'Link buku wajib diisi.',
            'link_url.url'      => 'Link buku harus berupa URL yang valid.',
        ]);

        Buku::create([
            'judul'     => $validated['judul'],
            'slug'      => $validated['slug'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'link_url'  => $validated['link_url'],
            'user_id'   => auth()->id(),
        ]);

        return redirect()->route('admin.perpus.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function edit(Buku $perpu)
    {
        $buku = $perpu;
        return view('admin.perpus.edit', compact('buku'));
    }

    public function update(Request $request, Buku $perpu)
    {
        $buku = $perpu;

        $slug = $request->input('slug') ?: Str::slug((string)$request->input('judul'));
        $request->merge(['slug' => $slug]);

        $validated = $request->validate([
            'judul'     => 'required|string|max:255',
            'slug'      => 'required|string|max:255|unique:bukus,slug,'.$buku->id,
            'link_url'  => 'required|url|max:2048',
            'deskripsi' => 'nullable|string',
        ]);

        $buku->update($validated);

        return redirect()->route('admin.perpus.index')->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy(Buku $perpu)
    {
        $perpu->delete();
        return back()->with('success', 'Buku berhasil dihapus.');
    }

    // Ajax generator slug: /admin/perpus/slug?judul=...
    public function slug(Request $request)
    {
        $judul = (string) $request->get('judul', '');
        $slug  = Str::slug($judul);

        $base = $slug; $i = 1;
        while (Buku::where('slug', $slug)->exists()) {
            $slug = $base.'-'.$i++;
        }

        return response()->json(['slug' => $slug]);
    }
}
