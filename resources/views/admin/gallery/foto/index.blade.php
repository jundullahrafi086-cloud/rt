@extends('admin.layouts.main')

@section('content')
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif
  @if($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach($errors->all() as $e)
          <li>{{ $e }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="card shadow-sm mb-3">
    <div class="card-body d-flex justify-content-between align-items-center">
      <div>
        <h5 class="mb-0">{{ $album->judul }}</h5>
        <small class="text-muted">Kelola foto dalam album</small>
      </div>
      <a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
  </div>

  <div class="card shadow-sm mb-3">
    <div class="card-header"><strong>Unggah Foto</strong></div>
    <div class="card-body">
      <form method="POST" action="{{ route('admin.gallery.foto.store', $album->id) }}" enctype="multipart/form-data">
        @csrf
        <input type="file" name="fotos[]" class="form-control mb-2" accept="image/*" multiple required>
        <small class="text-muted">Maks 4MB per foto. Bisa pilih banyak file sekaligus.</small>
        <div class="text-end mt-3">
          <button class="btn btn-primary">Unggah</button>
        </div>
      </form>
    </div>
  </div>

  <div class="card shadow-sm">
    <div class="card-header"><strong>Foto di Album</strong></div>
    <div class="card-body">
      <div class="row g-3">
        @forelse($fotos as $foto)
          <div class="col-6 col-md-3">
            <div class="card h-100 shadow-sm border-0">
              <div class="ratio ratio-1x1">
                <img
                  {{-- SALAH: src="{{ $foto->image_url ?? '#' }}" --}}
                  {{-- BENAR: --}}
                  src="{{ $foto->img_url ?? '#' }}"
                  class="rounded-top"
                  style="object-fit:cover"
                  alt="{{ $foto->title ?? 'foto' }}"
                  loading="lazy">
              </div>
              <div class="card-body p-2 text-center">
                <form action="{{ route('admin.gallery.foto.destroy', [$album->id, $foto->id]) }}"
                      method="POST"
                      onsubmit="return confirm('Hapus foto ini?')">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-outline-danger w-100">Hapus</button>
                </form>
              </div>
            </div>
          </div>
        @empty
          <div class="col-12">
            <div class="alert alert-info mb-0">Belum ada foto.</div>
          </div>
        @endforelse
      </div>
      <div class="mt-3">{{ $fotos->links() }}</div>
    </div>
  </div>
@endsection