<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\GalleryGroup;

class GalleryController extends Controller
{
    // daftar album
    public function indexAlbum()
    {
        $albums = GalleryGroup::where('is_published',1)
            ->orderByDesc('created_at')->paginate(12);

        return view('gallery.albums.index', compact('albums'));
    }

    // detail album (foto2)
    public function albumDetail(string $slug)
    {
        $album = GalleryGroup::where('slug',$slug)->where('is_published',1)->firstOrFail();

        $fotos = Gallery::where('group_id', $album->id)
            ->when(schema()->hasColumn('galleries','is_published'), fn($q)=>$q->where('is_published',1))
            ->orderByDesc('created_at')
            ->paginate(24);

        return view('gallery.albums.detail', compact('album','fotos'));
    }
}
