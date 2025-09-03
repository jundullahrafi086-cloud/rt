@extends('admin.layouts.main')

@section('content')
<div class="container-fluid py-3">
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Kepala Desa per Periode</h4>
    <a href="{{ route('kepala-desa.create') }}" class="btn btn-primary">+ Tambah</a>
  </div>

  <div class="card shadow-lg">
    <div class="card-body">
      @if($items->count() === 0)
        <p class="text-muted mb-0">Belum ada data kepala desa.</p>
      @else
        <div class="row g-3">
          @foreach($items as $item)
            <div class="col-md-4 col-lg-3">
              <div class="card shadow-lg h-100">
                <div class="ratio ratio-1x1">
                  <img src="{{ $item->foto ? asset('storage/'.$item->foto) : 'https://via.placeholder.com/400x400?text=Foto' }}"
                       alt="Foto Kepala Desa" class="img-fluid" style="object-fit: cover;">
                </div>
                <div class="card-body">
                  <h6 class="mb-1">{{ $item->nama }}</h6>
                  <div class="text-muted small mb-2">{{ $item->periode_label }}</div>
                  @if($item->catatan)
                    <p class="text-muted" style="min-height:48px;">{{ \Illuminate\Support\Str::limit($item->catatan, 80) }}</p>
                  @endif
                  <div class="d-flex gap-2">
                    <a href="{{ route('kepala-desa.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('kepala-desa.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus data ini?')">
                      @csrf @method('DELETE')
                      <button class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>

        <div class="mt-3">
          {{ $items->links() }}
        </div>
      @endif
    </div>
  </div>
</div>
@endsection
