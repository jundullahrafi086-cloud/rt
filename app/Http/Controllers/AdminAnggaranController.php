<?php

namespace App\Http\Controllers;

use App\Models\Anggaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminAnggaranController extends Controller
{
    public function index()
    {
        $items = Anggaran::latest()->paginate(15);
        return view('admin.apbdes.index', compact('items'));
    }

    public function create()
    {
        return view('admin.apbdes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'      => 'required|string|max:255',
            'slug'       => 'required|string|max:255|unique:anggarans,slug',
            'keterangan' => 'required|string',
            'dokumen'    => 'required|file|max:20480|mimes:pdf,xls,xlsx,csv,doc,docx,ppt,pptx,zip,rar',
            'gambar'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ], [], [
            'keterangan' => 'keterangan',
            'dokumen'    => 'dokumen APBDes',
        ]);

        $anggaran = Anggaran::create([
            'judul'     => $request->judul,
            'slug'      => $request->slug,
            'keterangan' => $request->keterangan,
            'user_id'   => auth()->id(),
        ]);

        // Upload dokumen (wajib)
        if ($request->hasFile('dokumen')) {
            $f = $request->file('dokumen');
            $path = $f->store('apbdes', 'public');
            $anggaran->update([
                'dokumen_path'     => $path,
                'dokumen_original' => $f->getClientOriginalName(),
                'dokumen_mime'     => $f->getClientMimeType(),
                'dokumen_size'     => $f->getSize(),
            ]);
        }

        // Cover (opsional)
        if ($request->hasFile('gambar')) {
            $g = $request->file('gambar');
            $imgPath = $g->store('apbdes-covers', 'public');
            $anggaran->update(['gambar' => $imgPath]);
        }

        return redirect()->route('admin.apbdes.index')->with('success', 'APBDes berhasil ditambahkan.');
    }

    // Resource parameter binding: {apbde}
    public function edit(Anggaran $apbde)
    {
        $anggaran = $apbde;
        return view('admin.apbdes.edit', compact('anggaran'));
    }

    public function update(Request $request, Anggaran $apbde)
    {
        $anggaran = $apbde;

        $request->validate([
            'judul'      => 'required|string|max:255',
            'slug'       => 'required|string|max:255|unique:anggarans,slug,'.$anggaran->id,
            'keterangan' => 'required|string',
            'dokumen'    => 'nullable|file|max:20480|mimes:pdf,xls,xlsx,csv,doc,docx,ppt,pptx,zip,rar',
            'gambar'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $anggaran->update([
            'judul'     => $request->judul,
            'slug'      => $request->slug,
            'keterangan' => $request->keterangan,
        ]);

        if ($request->hasFile('dokumen')) {
            // hapus dokumen lama
            if ($anggaran->dokumen_path && Storage::disk('public')->exists($anggaran->dokumen_path)) {
                Storage::disk('public')->delete($anggaran->dokumen_path);
            }
            $f = $request->file('dokumen');
            $path = $f->store('apbdes', 'public');
            $anggaran->update([
                'dokumen_path'     => $path,
                'dokumen_original' => $f->getClientOriginalName(),
                'dokumen_mime'     => $f->getClientMimeType(),
                'dokumen_size'     => $f->getSize(),
            ]);
        }

        if ($request->hasFile('gambar')) {
            if ($anggaran->gambar && Storage::disk('public')->exists($anggaran->gambar)) {
                Storage::disk('public')->delete($anggaran->gambar);
            }
            $g = $request->file('gambar');
            $imgPath = $g->store('apbdes-covers', 'public');
            $anggaran->update(['gambar' => $imgPath]);
        }

        return redirect()->route('admin.apbdes.index')->with('success', 'APBDes berhasil diperbarui.');
    }

    public function destroy(Anggaran $apbde)
    {
        $anggaran = $apbde;

        if ($anggaran->dokumen_path && Storage::disk('public')->exists($anggaran->dokumen_path)) {
            Storage::disk('public')->delete($anggaran->dokumen_path);
        }
        if ($anggaran->gambar && Storage::disk('public')->exists($anggaran->gambar)) {
            Storage::disk('public')->delete($anggaran->gambar);
        }

        $anggaran->delete();
        return back()->with('success', 'APBDes berhasil dihapus.');
    }

    // Hapus hanya file dokumen
    public function removeFile($id)
    {
        $anggaran = Anggaran::findOrFail($id);
        if ($anggaran->dokumen_path && Storage::disk('public')->exists($anggaran->dokumen_path)) {
            Storage::disk('public')->delete($anggaran->dokumen_path);
        }
        $anggaran->update([
            'dokumen_path' => null,
            'dokumen_original' => null,
            'dokumen_mime' => null,
            'dokumen_size' => null,
        ]);
        return back()->with('success', 'File APBDes berhasil dihapus.');
    }

    // /admin/apbdes/slug?judul=...
    public function slugify(Request $request)
    {
        $judul = (string) $request->get('judul', '');
        $slug = Str::slug($judul);

        $base = $slug;
        $i = 1;
        while (Anggaran::where('slug', $slug)->exists()) {
            $slug = $base.'-'.$i++;
        }
        return response()->json(['slug' => $slug]);
    }
}
