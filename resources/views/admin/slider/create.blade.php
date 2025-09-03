@extends('admin.layouts.main')

@section('content')
<div class="container-fluid py-3">
  <h4 class="mb-3">Tambah Slide</h4>

  @if ($errors->any())
    <div class="alert alert-danger">
      <strong>Periksa input:</strong>
      <ul class="mb-0">
        @foreach ($errors->all() as $e)
          <li>{{ $e }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="card shadow-lg">
    <div class="card-body">
      <form action="{{ route('slider.store') }}" method="POST" enctype="multipart/form-data" class="row g-3">
        @csrf

        <div class="col-md-6">
          <label class="form-label">Judul <span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="judul" value="{{ old('judul') }}" required>
        </div>

        <div class="col-12">
          <label class="form-label">Deskripsi <span class="text-danger">*</span></label>
          <textarea class="form-control" name="deskripsi" rows="3" required>{{ old('deskripsi') }}</textarea>
        </div>

        <div class="col-md-6">
          <label class="form-label">Gambar <span class="text-danger">*</span></label>
          <input type="file" class="form-control" name="img_slider" accept=".jpg,.jpeg,.png,.webp" required>
          <small class="text-muted">Rekomendasi rasio 16:9, maks 4 MB.</small>
        </div>

        <div class="col-md-6">
          <label class="form-label">Tautan Tombol (opsional)</label>
          <input type="text" class="form-control" name="link_btn" value="{{ old('link_btn') }}" placeholder="https://...">
        </div>

        <div class="col-12">
          <a href="{{ route('slider.index') }}" class="btn btn-secondary">Batal</a>
          <button class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
