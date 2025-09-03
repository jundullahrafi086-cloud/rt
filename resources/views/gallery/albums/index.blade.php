@extends('layouts.main')

@section('content')
<section class="py-5 bg-light">
  <div class="container">
    <h2 class="fw-bold text-center mb-4">Galeri Kegiatan</h2>

    <div class="row g-4">
      @forelse($albums as $album)
        <div class="col-12 col-sm-6 col-lg-4">
          <div class="card h-100 shadow-lg border-0">
            <div class="ratio ratio-16x9">
              <img src="{{ $album->cover_url ?? asset('images/album-default.jpg') }}" class="rounded-top" style="object-fit:cover" alt="cover">
            </div>
            <div class="card-body d-flex flex-column">
              <h5 class="fw-semibold mb-2">{{ $album->judul }}</h5>
              <p class="text-muted small mb-3">{{ \Illuminate\Support\Str::limit($album->deskripsi, 120) }}</p>
              <a href="{{ route('gallery.albums.detail', $album->slug) }}" class="btn btn-primary mt-auto">Lihat Album</a>
            </div>
          </div>
        </div>
      @empty
        <div class="col-12"><div class="alert alert-info">Belum ada album.</div></div>
      @endforelse
    </div>

    <div class="d-flex justify-content-center mt-4">{{ $albums->links() }}</div>
  </div>
</section>
@endsection
