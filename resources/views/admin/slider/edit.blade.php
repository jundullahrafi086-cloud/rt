@extends('admin.layouts.main')

@section('content')
<div class="container-fluid py-3">
  <h4 class="mb-3">Edit Slide</h4>

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
      <form action="{{ route('slider.update', $slider->id) }}" method="POST" enctype="multipart/form-data" class="row g-3">
        @csrf @method('PUT')

        <div class="col-md-6">
          <label class="form-label">Judul <span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="judul" value="{{ old('judul', $slider->judul) }}" required>
        </div>

        <div class="col-12">
          <label class="form-label">Deskripsi <span class="text-danger">*</span></label>
          <textarea class="form-control" name="deskripsi" rows="3" required>{{ old('deskripsi', $slider->deskripsi) }}</textarea>
        </div>

        <div class="col-md-6">
          <label class="form-label d-block">Gambar Saat Ini</label>
          <div class="ratio ratio-16x9 mb-2">
            <img src="{{ asset('storage/'.$slider->img_slider) }}" alt="current" class="img-fluid" style="object-fit: cover;">
          </div>
          <label class="form-label">Ganti Gambar (opsional)</label>
          <input type="file" class="form-control" name="img_slider" accept=".jpg,.jpeg,.png,.webp">
          <small class="text-muted">Kosongkan jika tidak ingin mengganti.</small>
        </div>

        <div class="col-md-6">
          <label class="form-label">Tautan Tombol (opsional)</label>
          <input type="text" class="form-control" name="link_btn" value="{{ old('link_btn', $slider->link_btn) }}" placeholder="https://...">
        </div>

        <div class="col-12">
          <a href="{{ route('slider.index') }}" class="btn btn-secondary">Kembali</a>
          <button class="btn btn-primary">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
