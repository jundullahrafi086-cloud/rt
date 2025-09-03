<?php

namespace App\Http\Controllers;

use App\Models\GalleryGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminGalleryGroupController extends Controller
{
    public function index()
    {
        $items = GalleryGroup::latest()->paginate(12);
        return view('admin.gallery.index', compact('items'));
    }

    public function create()
    {
        return view('admin.gallery.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'     => 'required|string|max:255',
            'slug'      => 'required|string|max:255|unique:gallery_groups,slug',
            'deskripsi' => 'nullable|string',
            'cover'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $album = GalleryGroup::create([
            'judul'     => $request->judul,
            'slug'      => $request->slug,
            'deskripsi' => $request->deskripsi,
        ]);

        if ($request->hasFile('cover')) {
            $path = $request->file('cover')->store('gallery/albums/covers', 'public');
            $album->update(['cover' => $path]);
        }

        return redirect()->route('admin.gallery.index')->with('success', 'Album berhasil dibuat.');
    }

    public function edit(GalleryGroup $album)
    {
        return view('admin.gallery.edit', compact('album'));
    }

    public function update(Request $request, GalleryGroup $album)
    {
        $request->validate([
            'judul'     => 'required|string|max:255',
            'slug'      => 'required|string|max:255|unique:gallery_groups,slug,'.$album->id,
            'deskripsi' => 'nullable|string',
            'cover'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $album->update([
            'judul'     => $request->judul,
            'slug'      => $request->slug,
            'deskripsi' => $request->deskripsi,
        ]);

        if ($request->hasFile('cover')) {
            if ($album->cover && Storage::disk('public')->exists($album->cover)) {
                Storage::disk('public')->delete($album->cover);
            }
            $path = $request->file('cover')->store('gallery/albums/covers', 'public');
            $album->update(['cover' => $path]);
        }

        return redirect()->route('admin.gallery.index')->with('success', 'Album berhasil diperbarui.');
    }

    public function destroy(GalleryGroup $album)
    {
        if ($album->cover && Storage::disk('public')->exists($album->cover)) {
            Storage::disk('public')->delete($album->cover);
        }
        $album->delete();
        return back()->with('success', 'Album dihapus.');
    }

    // GET /admin/gallery/slug?judul=...
    public function slug(Request $request)
    {
        $judul = (string) $request->get('judul', '');
        $slug  = Str::slug($judul);
        $base  = $slug; $i = 1;
        while (GalleryGroup::where('slug', $slug)->exists()) {
            $slug = $base.'-'.$i++;
        }
        return response()->json(['slug' => $slug]);
    }
}
