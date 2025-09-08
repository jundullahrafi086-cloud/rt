<?php

namespace App\Http\Controllers;

use App\Models\Anggaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminAnggaranController extends Controller
{
    /**
     * List APBDes (paginated).
     */
    public function index()
    {
        $items = Anggaran::orderByDesc('created_at')->paginate(12);
        return view('admin.apbdes.index', compact('items'));
    }

    /**
     * Form create.
     */
    public function create()
    {
        return view('admin.apbdes.create');
    }

    /**
     * Generate slug dari judul (AJAX).
     */
    public function slug(Request $request)
    {
        $judul = (string) $request->query('judul', '');
        $base  = Str::slug($judul);

        $slug  = $base;
        $i = 2;
        while (Anggaran::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $i++;
        }

        return response()->json(['slug' => $slug]);
    }

    /**
     * Simpan APBDes baru.
     */
    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'judul'      => 'required|string|max:255',
            'slug'       => 'required|string|max:255|unique:anggarans,slug',
            'keterangan' => 'required|string',
            'dokumen'    => 'required|file|max:204800|mimes:pdf,xls,xlsx,csv,doc,docx,ppt,pptx,zip,rar',
            'gambar'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:20240',
        ], [], [
            'keterangan' => 'keterangan',
            'dokumen'    => 'dokumen APBDes',
        ]);

        // Upload dokumen (wajib)
        $dokumen    = $request->file('dokumen');
        $dokPath    = $dokumen->store('apbdes', 'public');

        // Upload gambar (opsional)
        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('apbdes-cover', 'public');
        }

        // Simpan sekali dengan data lengkap
        $anggaran = Anggaran::create([
            'judul'            => $request->input('judul'),
            'slug'             => $request->input('slug'),
            'keterangan'       => $request->input('keterangan'),
            'gambar'           => $gambarPath, // nullable
            'dokumen_path'     => $dokPath,
            'dokumen_original' => $dokumen->getClientOriginalName(),
            'dokumen_mime'     => $dokumen->getClientMimeType(),
            'dokumen_size'     => $dokumen->getSize(),
            'user_id'          => auth()->id(),
        ]);

        return redirect()->route('apbdes.index')->with('success', 'APBDes berhasil ditambahkan.');
    }

    /**
     * Form edit.
     */
    public function edit(Anggaran $apbde) // route model binding: 'apbdes' => $apbde
    {
        // Catatan: nama parameter default resource adalah sesuai model singular
        // Kalau ingin $anggaran, bisa ubah signature dan route key name.
        $anggaran = $apbde;
        return view('admin.apbdes.edit', compact('anggaran'));
    }

    /**
     * Update APBDes.
     */
    public function update(Request $request, Anggaran $apbde)
    {
        $anggaran = $apbde;

        // Validasi; slug harus unik kecuali dirinya sendiri
        $request->validate([
            'judul'      => 'required|string|max:255',
            'slug'       => 'required|string|max:255|unique:anggarans,slug,' . $anggaran->id,
            'keterangan' => 'required|string',
            'dokumen'    => 'nullable|file|max:204800|mimes:pdf,xls,xlsx,csv,doc,docx,ppt,pptx,zip,rar',
            'gambar'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:20240',
        ], [], [
            'keterangan' => 'keterangan',
            'dokumen'    => 'dokumen APBDes',
        ]);

        $data = [
            'judul'      => $request->input('judul'),
            'slug'       => $request->input('slug'),
            'keterangan' => $request->input('keterangan'),
        ];

        // Jika upload gambar baru → hapus yang lama + simpan yang baru
        if ($request->hasFile('gambar')) {
            if ($anggaran->gambar && Storage::disk('public')->exists($anggaran->gambar)) {
                Storage::disk('public')->delete($anggaran->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('apbdes-cover', 'public');
        }

        // Jika upload dokumen baru → hapus dok lama + simpan yang baru
        if ($request->hasFile('dokumen')) {
            if ($anggaran->dokumen_path && Storage::disk('public')->exists($anggaran->dokumen_path)) {
                Storage::disk('public')->delete($anggaran->dokumen_path);
            }
            $dokumen = $request->file('dokumen');
            $dokPath = $dokumen->store('apbdes', 'public');

            $data['dokumen_path']     = $dokPath;
            $data['dokumen_original'] = $dokumen->getClientOriginalName();
            $data['dokumen_mime']     = $dokumen->getClientMimeType();
            $data['dokumen_size']     = $dokumen->getSize();
        }

        $anggaran->update($data);

        return redirect()->route('apbdes.index')->with('success', 'APBDes berhasil diperbarui.');
    }

    /**
     * Hapus APBDes + file terkait.
     */
    public function destroy(Anggaran $apbde)
    {
        $anggaran = $apbde;

        // Hapus file dokumen
        if ($anggaran->dokumen_path && Storage::disk('public')->exists($anggaran->dokumen_path)) {
            Storage::disk('public')->delete($anggaran->dokumen_path);
        }

        // Hapus file gambar
        if ($anggaran->gambar && Storage::disk('public')->exists($anggaran->gambar)) {
            Storage::disk('public')->delete($anggaran->gambar);
        }

        $anggaran->delete();

        return redirect()->route('apbdes.index')->with('success', 'APBDes berhasil dihapus.');
    }
}
