@extends('admin.layouts.main')

@section('title','Edit Buku')

@section('content')
<div class="row">
  <div class="col-lg-12 d-flex align-items-stretch">
    <div class="card shadow-lg w-100">
      <div class="card-header bg-primary">
        <h5 class="card-title fw-semibold text-white mb-0">Edit Buku</h5>
      </div>

      <div class="card-body">
        @if ($errors->any())
          <div class="alert alert-danger">
            <ul class="mb-0">
              @foreach ($errors->all() as $e)
                <li>{{ $e }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form action="{{ route('admin.perpus.update', $buku) }}" method="POST">
          @csrf
          @method('PUT')

          <div class="mb-3">
            <label class="form-label">Judul</label>
            <input type="text" name="judul" class="form-control" value="{{ old('judul', $buku->judul) }}" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Slug</label>
            <div class="input-group">
              <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug', $buku->slug) }}" required>
              <button class="btn btn-outline-secondary" type="button" id="btn-slug">Buat Slug</button>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Link Buku (URL)</label>
            <input type="url" name="link_url" class="form-control" value="{{ old('link_url', $buku->link_url) }}" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Deskripsi (opsional)</label>
            <textarea name="deskripsi" rows="5" class="form-control">{{ old('deskripsi', $buku->deskripsi) }}</textarea>
          </div>

          <div class="d-flex gap-2">
            <button class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.perpus.index') }}" class="btn btn-light">Kembali</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  document.getElementById('btn-slug').addEventListener('click', async () => {
    const judul = document.querySelector('[name="judul"]').value || '';
    const url   = new URL('{{ route('admin.perpus.slug') }}', window.location.origin);
    url.searchParams.set('judul', judul);
    const res   = await fetch(url);
    const json  = await res.json();
    document.getElementById('slug').value = json.slug || '';
  });
</script>
@endsection
