@extends('layouts.main')

@section('content')
<section class="py-5">
  <div class="container">
    <h3 class="fw-bold mb-1">{{ $album->judul }}</h3>
    <p class="text-muted">{{ $album->deskripsi }}</p>

    <div class="row g-3">
      @forelse($fotos as $foto)
        <div class="col-6 col-md-3">
          <a href="{{ $foto->img_url }}" target="_blank" class="d-block card shadow-sm border-0">
            <div class="ratio ratio-1x1">
              <img src="{{ $foto->img_url }}" class="rounded" style="object-fit:cover" alt="foto">
            </div>
          </a>
        </div>
      @empty
        <div class="col-12"><div class="alert alert-info">Belum ada foto di album ini.</div></div>
      @endforelse
    </div>

    <div class="d-flex justify-content-center mt-4">{{ $fotos->links() }}</div>
  </div>
</section>
@endsection
