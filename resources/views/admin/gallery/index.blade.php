@extends('admin.layouts.main')
@section('content')
@if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

<div class="card shadow-sm mb-3">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0">Galeri (Album)</h5>
    <a href="{{ route('admin.gallery.create') }}" class="btn btn-primary">Buat Album</a>
  </div>
  <div class="card-body">
    <div class="row g-4">
      @forelse($items as $album)
        <div class="col-md-4">
          <div class="card h-100 shadow-sm border-0">
            <div class="ratio ratio-16x9 overflow-hidden">
              <img src="{{ $album->cover_url ?? asset('images/album-default.jpg') }}"
                   class="rounded-top" style="object-fit:cover" alt="cover">
            </div>
            <div class="card-body">
              <h6 class="fw-semibold mb-1">{{ $album->judul }}</h6>
              <p class="small text-muted mb-3">{{ \Illuminate\Support\Str::limit($album->deskripsi, 100) }}</p>
              <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('admin.gallery.foto.index', $album->id) }}" class="btn btn-sm btn-info">Kelola Foto</a>
                <a href="{{ route('admin.gallery.edit', $album->id) }}" class="btn btn-sm btn-secondary">Edit</a>
                <form method="POST" action="{{ route('admin.gallery.destroy', $album->id) }}"
                      onsubmit="return confirm('Hapus album ini?')">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-danger">Hapus</button>
                </form>
              </div>
            </div>
            <div class="card-footer bg-white small text-muted">
              Diperbarui {{ $album->updated_at?->format('d M Y H:i') }}
            </div>
          </div>
        </div>
      @empty
        <div class="col-12"><div class="alert alert-info">Belum ada album.</div></div>
      @endforelse
    </div>
    <div class="mt-3">{{ $items->links() }}</div>
  </div>
</div>
@endsection
