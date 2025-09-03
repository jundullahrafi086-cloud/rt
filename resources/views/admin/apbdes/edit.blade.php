@extends('admin.layouts.main')

@section('content')
<form method="POST" action="{{ route('admin.apbdes.update', $anggaran->id) }}" enctype="multipart/form-data">
@csrf @method('PUT')

<div class="row">
  <div class="col-lg-8">
    <div class="card shadow-lg">
      <div class="card-body">
        <div class="mb-3">
          <label class="form-label">Judul</label>
          <input type="text" class="form-control" name="judul" value="{{ old('judul',$anggaran->judul) }}" required>
          @error('judul')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
          <label class="form-label">Slug</label>
          <input type="text" class="form-control" name="slug" value="{{ old('slug',$anggaran->slug) }}" required>
          @error('slug')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
          <label class="form-label">Keterangan</label>
          <textarea class="form-control" name="keterangan" rows="8" required>{{ old('keterangan',$anggaran->keterangan) }}</textarea>
          @error('keterangan')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
          <label class="form-label">File Dokumen APBDes (PDF/Excel/Word/ZIP)</label>
          @if($anggaran->dokumen_path)
            <div class="mb-2">
              <a class="btn btn-sm btn-info" target="_blank" href="{{ $anggaran->dokumen_url }}">Buka saat ini</a>
              <span class="small text-muted ms-2">{{ $anggaran->dokumen_original }} ({{ number_format(($anggaran->dokumen_size ?? 0)/1024,0) }} KB)</span>
              <form action="{{ route('admin.apbdes.file.remove', $anggaran->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus file saat ini?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger ms-2">Hapus File</button>
              </form>
            </div>
          @endif
          <input class="form-control" type="file" name="dokumen" accept=".pdf,.xls,.xlsx,.csv,.doc,.docx,.ppt,.pptx,.zip,.rar">
          @error('dokumen')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="card shadow-lg">
      <div class="card-body">
        <div class="mb-3">
          @if($anggaran->gambar_url)
            <img src="{{ $anggaran->gambar_url }}" class="img-fluid rounded mb-2" style="max-height:300px">
          @endif
          <label class="form-label">Gambar Sampul (opsional)</label>
          <input class="form-control" type="file" name="gambar" accept="image/*">
          @error('gambar')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <div class="d-flex gap-2">
          <a href="{{ route('apbdesa.index') }}" class="btn btn-secondary">Kembali</a>
          <button class="btn btn-primary ms-auto" type="submit">Simpan</button>
        </div>
      </div>
    </div>
  </div>
</div>
</form>
@endsection
