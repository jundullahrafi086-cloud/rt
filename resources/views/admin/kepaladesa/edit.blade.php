@extends('admin.layouts.main')

@section('content')
<div class="container-fluid py-3">
  <h4 class="mb-3">Edit Kepala Desa</h4>

  @if($errors->any())
    <div class="alert alert-danger">
      <strong>Periksa input:</strong>
      <ul class="mb-0">
        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
      </ul>
    </div>
  @endif

  <div class="card shadow-lg">
    <div class="card-body">
      <form action="{{ route('kepala-desa.update', $item->id) }}" method="POST" enctype="multipart/form-data" class="row g-3">
        @csrf @method('PUT')

        <div class="col-md-6">
          <label class="form-label">Nama <span class="text-danger">*</span></label>
          <input type="text" name="nama" class="form-control" value="{{ old('nama', $item->nama) }}" required>
        </div>

        <div class="col-md-3">
          <label class="form-label">Periode Mulai</label>
          <input type="text" name="periode_mulai" class="form-control" value="{{ old('periode_mulai', $item->periode_mulai) }}">
        </div>

        <div class="col-md-3">
          <label class="form-label">Periode Selesai</label>
          <input type="text" name="periode_selesai" class="form-control" value="{{ old('periode_selesai', $item->periode_selesai) }}">
        </div>

        <div class="col-md-4">
          <label class="form-label d-block">Foto Saat Ini</label>
          <div class="ratio ratio-1x1 mb-2">
            <img src="{{ $item->foto ? asset('storage/'.$item->foto) : 'https://via.placeholder.com/400x400?text=Foto' }}"
                 class="img-fluid" style="object-fit: cover;">
          </div>
          <label class="form-label">Ganti Foto (opsional)</label>
          <input type="file" name="foto" class="form-control" accept=".jpg,.jpeg,.png,.webp">
        </div>

        <div class="col-md-8">
          <label class="form-label">Catatan (opsional)</label>
          <textarea name="catatan" class="form-control" rows="6">{{ old('catatan', $item->catatan) }}</textarea>
        </div>

        <div class="col-12">
          <a href="{{ route('kepala-desa.index') }}" class="btn btn-secondary">Kembali</a>
          <button class="btn btn-primary">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
