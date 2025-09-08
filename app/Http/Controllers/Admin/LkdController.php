<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Lkd\StoreLkdRequest;
use App\Http\Requests\Lkd\UpdateLkdRequest;
use App\Models\Lkd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LkdController extends Controller
{
    public function index() {
        $items = Lkd::latest('id')->paginate(12);
        return view('admin.lkd.index', compact('items'));
    }

    public function create() {
        return view('admin.lkd.create');
    }

    public function store(StoreLkdRequest $request) {
        $data = $request->validated();
        $data['published'] = (bool)($data['published'] ?? false);
        $data['created_by'] = auth()->id();
        $data['slug'] = \Illuminate\Support\Str::slug($data['judul']);
    
    // Pastikan slug unik
    $count = 1;
    $originalSlug = $data['slug'];
    while (\App\Models\Lkd::where('slug', $data['slug'])->exists()) {
        $data['slug'] = $originalSlug . '-' . $count++;
    }


        // === Upload cover (meniru logika Berita): public disk, folder bertanggal, nama unik ===
        if ($request->hasFile('cover')) {
            $file     = $request->file('cover');
            $datePath = now()->format('Y/m/d');
            // simpan dalam namespace "berita/lkd" agar konsisten dengan modul berita
            $dir      = "berita/lkd/{$datePath}";
            $name     = Str::random(40).'.'.$file->getClientOriginalExtension();
            $path     = $file->storeAs($dir, $name, 'public');
            $data['cover_path'] = $path;
        }

        $lkd = Lkd::create($data);
        return redirect()->route('admin.lkd.edit', $lkd)->with('success','LKD dibuat.');
    }

    public function edit(Lkd $lkd) {
        $lkd->load('members');
        return view('admin.lkd.edit', compact('lkd'));
    }

   public function update(UpdateLkdRequest $request, Lkd $lkd)
{
    $data = $request->validated();
    $data['published'] = (bool)($data['published'] ?? false);

    if ($request->hasFile('cover')) {
        if ($lkd->cover_path && Storage::disk('public')->exists($lkd->cover_path)) {
            Storage::disk('public')->delete($lkd->cover_path);
        }
        $file     = $request->file('cover');
        $datePath = now()->format('Y/m/d');
        $dir      = "berita/lkd/{$datePath}";
        $name     = Str::random(40).'.'.$file->getClientOriginalExtension();
        $path     = $file->storeAs($dir, $name, 'public');
        $data['cover_path'] = $path;
    }

    $lkd->update($data);

    // 🔑 ubah bagian redirect
    return redirect()
        ->route('admin.lkd.index')
        ->with('success','LKD berhasil diperbarui.');
}


    public function destroy(Lkd $lkd) {
        $lkd->delete(); // cover & members ikut bersih via events+FK cascade
        return redirect()->route('admin.lkd.index')->with('success','LKD dihapus.');
    }
}
