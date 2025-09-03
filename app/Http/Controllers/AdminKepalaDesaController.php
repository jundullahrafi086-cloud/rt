<?php

namespace App\Http\Controllers;

use App\Models\KepalaDesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;   // <-- penting: import Schema facade
use Illuminate\Support\Facades\Storage;

class AdminKepalaDesaController extends Controller
{
    public function index()
    {
        $items = KepalaDesa::orderByDesc('periode_mulai')
            ->orderByDesc('periode_selesai')
            ->orderBy('nama')
            ->paginate(12);

        return view('admin.kepaladesa.index', compact('items'));
    }

    public function create()
    {
        return view('admin.kepaladesa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'            => ['required','string','max:255'],
            'periode_mulai'   => ['nullable','string','max:10'],
            'periode_selesai' => ['nullable','string','max:10'],
            'foto'            => ['nullable','image','mimes:jpg,jpeg,png,webp','max:4096'],
            'catatan'         => ['nullable','string'],
        ]);

        $data = $request->only(['nama','periode_mulai','periode_selesai','catatan']);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('kepala-desa', 'public');
        }

        // ✅ perbaikan: gunakan Schema::hasColumn (bukan Schema())
        if (Schema::hasColumn('kepala_desas', 'user_id') && auth()->check()) {
            $data['user_id'] = auth()->id();
        }

        KepalaDesa::create($data);

        return redirect()->route('kepala-desa.index')->with('success', 'Data kepala desa ditambahkan.');
    }

    public function edit(KepalaDesa $kepala_desa)
    {
        return view('admin.kepaladesa.edit', ['item' => $kepala_desa]);
    }

    public function update(Request $request, KepalaDesa $kepala_desa)
    {
        $request->validate([
            'nama'            => ['required','string','max:255'],
            'periode_mulai'   => ['nullable','string','max:10'],
            'periode_selesai' => ['nullable','string','max:10'],
            'foto'            => ['nullable','image','mimes:jpg,jpeg,png,webp','max:4096'],
            'catatan'         => ['nullable','string'],
        ]);

        $data = $request->only(['nama','periode_mulai','periode_selesai','catatan']);

        if ($request->hasFile('foto')) {
            if ($kepala_desa->foto && Storage::disk('public')->exists($kepala_desa->foto)) {
                Storage::disk('public')->delete($kepala_desa->foto);
            }
            $data['foto'] = $request->file('foto')->store('kepala-desa', 'public');
        }

        // ✅ perbaikan: gunakan Schema::hasColumn (bukan Schema())
        if (Schema::hasColumn('kepala_desas', 'user_id') && auth()->check()) {
            $data['user_id'] = auth()->id();
        }

        $kepala_desa->update($data);

        return redirect()->route('kepala-desa.index')->with('success', 'Data kepala desa diperbarui.');
    }

    public function destroy(KepalaDesa $kepala_desa)
    {
        if ($kepala_desa->foto && Storage::disk('public')->exists($kepala_desa->foto)) {
            Storage::disk('public')->delete($kepala_desa->foto);
        }
        $kepala_desa->delete();

        return redirect()->route('kepala-desa.index')->with('success', 'Data kepala desa dihapus.');
    }
}
