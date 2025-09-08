@extends('admin.layouts.main')

@section('content')
<div class="row">
  <div class="col-lg-12 d-flex align-items-strech">
    <div class="card shadow-lg w-100">
      <div class="card-header bg-primary">
        <div class="row align-items-center">
          <div class="col-6">
            <h5 class="card-title fw-semibold text-white">Tambah APBDes</h5>
          </div>
          <div class="col-6 text-right">
            <a href="{{ route('apbdes.index') }}" type="button" class="btn btn-warning float-end">Kembali</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<form method="POST" action="{{ route('apbdes.store') }}" enctype="multipart/form-data" id="form-apbdes">
@csrf
<div class="row">
  <div class="col-lg-8">
    <div class="card shadow-lg">
      <div class="card-body">
        @if ($errors->any())
          <div class="alert alert-danger">
            <strong>Periksa input:</strong>
            <ul class="mb-0">
              @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
          </div>
        @endif

        <div class="mb-3">
          <label class="form-label">Judul <span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="judul" id="judul" value="{{ old('judul') }}" required>
          @error('judul')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
          <label class="form-label">Slug/Permalink <span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="slug" id="slug" value="{{ old('slug') }}" required>
          @error('slug')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
          <label class="form-label">Keterangan <span class="text-danger">*</span></label>
          <textarea class="form-control" id="editor" name="keterangan" rows="10">{{ old('keterangan') }}</textarea>
          @error('keterangan')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
          <label class="form-label">File Dokumen APBDes (PDF/Excel/Word/ZIP) <span class="text-danger">*</span></label>
          <input class="form-control" type="file" id="dokumen" name="dokumen"
                 accept=".pdf,.xls,.xlsx,.csv,.doc,.docx,.ppt,.pptx,.zip,.rar" required>
          <small class="text-muted d-block mt-1">Maks 200MB. Format: PDF, XLS/XLSX/CSV, DOC/DOCX, PPT/PPTX, ZIP/RAR.</small>
          @error('dokumen')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="card shadow-lg">
      <div class="card-body">
        <div class="mb-3">
          <img src="" class="img-preview img-fluid mb-3 mt-2" id="preview" style="border-radius:5px; max-height:300px; overflow:hidden;">
          <label class="form-label">Gambar Sampul (opsional)</label>
          <input class="form-control" type="file" id="gambar" name="gambar" accept="image/*" onchange="previewImage()">
          @error('gambar')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <button type="submit" class="btn btn-primary float-end">Simpan</button>
      </div>
    </div>
  </div>
</div>
</form>

{{-- Slug otomatis --}}
<script>
  const judul = document.querySelector('#judul');
  const slug  = document.querySelector('#slug');
  if (judul) {
    judul.addEventListener('change', function(){
      fetch('{{ route('apbdes.slug') }}?judul=' + encodeURIComponent(judul.value))
        .then(r => r.json())
        .then(d => { if (d && d.slug) slug.value = d.slug })
        .catch(() => {});
    });
  }
</script>

<script>
  function previewImage() {
    const input = document.getElementById('gambar');
    const preview = document.getElementById('preview');
    preview.src = (input.files && input.files[0]) ? URL.createObjectURL(input.files[0]) : '';
  }
</script>

{{-- CKEditor (opsional) --}}
<script>
  if (window.ClassicEditor) {
    ClassicEditor.create(document.querySelector('#editor')).catch(console.error);
  }
</script>
@endsection
