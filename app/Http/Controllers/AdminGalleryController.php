<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\GalleryGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminGalleryController extends Controller
{
    // Halaman foto per album
    public function indexByAlbum(GalleryGroup $album)
    {
        $fotos = Gallery::where('group_id', $album->id)
            ->orderByDesc('created_at')->paginate(24);

        return view('admin.gallery.foto.index', compact('album','fotos'));
    }

    // Upload banyak foto ke album
    public function storeToAlbum(Request $request, GalleryGroup $album)
    {
        $request->validate([
            'fotos'   => ['required'],
            'fotos.*' => ['image','mimes:jpg,jpeg,png,webp','max:4096'],
        ]);

        if ($request->hasFile('fotos')) {
            foreach ($request->file('fotos') as $img) {
                $stored = $img->store("gallery/albums/{$album->id}", 'public');

                // Isi kedua kolom (path + gambar) agar kompatibel dgn skema lama.
                Gallery::create([
                    'group_id'     => $album->id,
                    'title'        => pathinfo($img->getClientOriginalName(), PATHINFO_FILENAME),
                    'description'  => null,
                    'is_published' => true,
                    'path'         => $stored,
                    'gambar'       => $stored,
                ]);
            }
        }

        return back()->with('success','Foto berhasil diunggah.');
    }

    // Hapus satu foto di album
    public function destroyFromAlbum(GalleryGroup $album, Gallery $foto)
    {
        abort_if($foto->group_id !== $album->id, 404);
        $foto->delete();
        return back()->with('success','Foto dihapus.');
    }
}
