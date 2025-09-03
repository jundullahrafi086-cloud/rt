@extends('admin.layouts.main')
@section('content')
<form method="POST" action="{{ route('admin.gallery.update', $album->id) }}" enctype="multipart/form-data" class="card shadow-sm">
  @csrf @method('PUT')
  <div class="card-header"><strong>Edit Album</strong></div>
  <div class="card-body">
    <div class="mb-3">
      <label class="form-label">Judul <span class="text-danger">*</span></label>
      <input type="text" class="form-control" name="judul" id="judul" value="{{ old('judul', $album->judul) }}" required>
      @error('judul') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>
    <div class="mb-3">
      <label class="form-label">Slug <span class="text-danger">*</span></label>
      <input type="text" class="form-control" name="slug" id="slug" value="{{ old('slug', $album->slug) }}" required>
      @error('slug') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>
    <div class="mb-3">
      <label class="form-label">Deskripsi</label>
      <textarea class="form-control" name="deskripsi" rows="4">{{ old('deskripsi', $album->deskripsi) }}</textarea>
      @error('deskripsi') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>
    <div class="mb-3">
      <label class="form-label">Cover (opsional)</label>
      <input type="file" class="form-control" name="cover" accept="image/*">
      @error('cover') <div class="text-danger small">{{ $message }}</div> @enderror

      @if($album->cover_url)
        <div class="mt-2">
          <img src="{{ $album->cover_url }}" class="img-fluid rounded" style="max-height: 160px; object-fit:cover;" alt="cover">
        </div>
      @endif
    </div>
  </div>
  <div class="card-footer text-end">
    <a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary">Batal</a>
    <button class="btn btn-primary">Simpan</button>
  </div>
</form>

<script>
const judul = document.querySelector('#judul'), slug = document.querySelector('#slug');
judul?.addEventListener('change', () => {
  fetch('{{ route('admin.gallery.slug') }}?judul='+encodeURIComponent(judul.value))
    .then(r=>r.json()).then(d => slug.value = d.slug).catch(()=>{});
});
</script>
@endsection
