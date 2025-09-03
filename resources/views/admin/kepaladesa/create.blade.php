@extends('admin.layouts.main')

@section('content')
<div class="container-fluid py-3">
  <h4 class="mb-3">Tambah Kepala Desa</h4>

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
      <form action="{{ route('kepala-desa.store') }}" method="POST" enctype="multipart/form-data" class="row g-3">
        @csrf

        <div class="col-md-6">
          <label class="form-label">Nama <span class="text-danger">*</span></label>
          <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
        </div>

        <div class="col-md-3">
          <label class="form-label">Periode Mulai</label>
          <input type="text" name="periode_mulai" class="form-control" value="{{ old('periode_mulai') }}" placeholder="mis. 1998">
        </div>

        <div class="col-md-3">
          <label class="form-label">Periode Selesai</label>
          <input type="text" name="periode_selesai" class="form-control" value="{{ old('periode_selesai') }}" placeholder="mis. 2004 / sekarang">
        </div>

        <div class="col-md-6">
          <label class="form-label">Foto (opsional)</label>
          <input type="file" name="foto" class="form-control" accept=".jpg,.jpeg,.png,.webp">
          <small class="text-muted">Maks 4 MB. Rasio 1:1 atau 4:5 disarankan.</small>
        </div>

        <div class="col-12">
          <label class="form-label">Catatan (opsional)</label>
          <textarea name="catatan" class="form-control" rows="3">{{ old('catatan') }}</textarea>
        </div>

        <div class="col-12">
          <a href="{{ route('kepala-desa.index') }}" class="btn btn-secondary">Batal</a>
          <button class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
