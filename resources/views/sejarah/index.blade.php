@extends('layouts.main')

@section('content')
<section class="py-4">
  <div class="container" data-aos="fade-up">
    <div class="row">
      <div class="col-lg-10 mx-auto">

        {{-- Artikel/Body Sejarah --}}
        @if($sejarah)
          <h2 class="mb-3">{{ $sejarah->judul }}</h2>
          <div class="content mb-5">
            {!! $sejarah->body !!}
          </div>
        @else
          <div class="alert alert-info">Belum ada konten sejarah.</div>
        @endif

        {{-- Daftar Kepala Desa per Periode --}}
        <div class="d-flex align-items-center mb-3">
          <h3 class="mb-0">Daftar Kepala Desa</h3>
          <span class="ms-2 text-muted">/ per periode</span>
        </div>

        @if($kepalaDesas->count() > 0)
          <div class="timeline">
            @foreach($kepalaDesas as $k)
              <div class="timeline-item d-flex gap-3 py-3 border-bottom" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 6) * 100 }}">
                <div class="flex-shrink-0" style="width:80px;">
                  <div class="ratio ratio-1x1 rounded" style="overflow:hidden; background:#f6f6f6;">
                    <img
                      src="{{ $k->foto ? asset('storage/'.$k->foto) : 'https://via.placeholder.com/400x400?text=Foto' }}"
                      alt="Foto {{ $k->nama }}" style="object-fit:cover;">
                  </div>
                </div>
                <div class="flex-grow-1">
                  <div class="d-flex flex-wrap align-items-center gap-2">
                    <h5 class="mb-0">{{ $k->nama }}</h5>
                    <span class="badge bg-primary">{{ $k->periode_label }}</span>
                  </div>
                  @if($k->catatan)
                    <p class="mb-0 text-muted mt-1">{{ $k->catatan }}</p>
                  @endif
                </div>
              </div>
            @endforeach
          </div>
        @else
          <div class="alert alert-warning">Belum ada data kepala desa.</div>
        @endif

      </div>
    </div>
  </div>
</section>
@endsection

@push('styles')
<style>
  .timeline-item:last-child { border-bottom: 0; }
</style>
@endpush
