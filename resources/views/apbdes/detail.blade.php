@extends('layouts.main')

@section('content')
<div class="container py-4">

  <div class="row">
    <div class="col-lg-9">
      <article class="card shadow-sm">
        <div class="card-body">
          <h1 class="h3">{{ $anggaran->judul }}</h1>
          <div class="text-muted small mb-3">
            Diterbitkan {{ $anggaran->created_at->format('d M Y') }}
          </div>

          {{-- Gambar cover (konsisten dengan admin) --}}
          <div class="mb-3" style="background:#f6f6f6; border-radius:6px; overflow:hidden;">
  @if($anggaran->gambar)
    <img src="{{ asset('storage/'.$anggaran->gambar) }}" 
         alt="Cover {{ $anggaran->judul }}" 
         class="img-fluid" 
         style="display:block; max-width:100%; height:auto;">
  @else
    <div class="d-flex align-items-center justify-content-center text-muted" style="height:200px;">
      Tidak ada gambar
    </div>
  @endif
</div>

          {{-- Konten keterangan (HTML dari editor) --}}
          <div class="mb-3">
            {!! $anggaran->keterangan !!}
          </div>

          {{-- Tombol unduh dokumen jika ada --}}
          @if($anggaran->dokumen_path)
            @php
              // helper format size sederhana
              function human_filesize($bytes, $decimals = 1) {
                  $size = ['B','KB','MB','GB','TB'];
                  $factor = floor((strlen($bytes) - 1) / 3);
                  return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . ' ' . $size[$factor];
              }
            @endphp
            <div class="alert alert-light border d-flex align-items-center justify-content-between">
              <div>
                <div class="fw-semibold">Dokumen APBDes</div>
                <div class="small text-muted">
                  {{ $anggaran->dokumen_original ?: basename($anggaran->dokumen_path) }}
                  @if(!empty($anggaran->dokumen_size))
                    • {{ human_filesize((int)$anggaran->dokumen_size) }}
                  @endif
                </div>
              </div>
              <a href="{{ asset('storage/'.$anggaran->dokumen_path) }}" target="_blank" class="btn btn-outline-secondary">
                Unduh
              </a>
            </div>
          @endif
        </div>
      </article>
    </div>

    {{-- Sidebar: APBDes lain (terkait/terbaru) --}}
    <div class="col-lg-3">
      <div class="card shadow-sm">
        <div class="card-body">
          <h5 class="mb-3">APBDes Lainnya</h5>
          @forelse($related as $r)
            <div class="d-flex gap-2 mb-3">
              <div style="width:84px; height:56px; border-radius:4px; overflow:hidden; background:#f1f1f1;">
                @if($r->gambar)
                  <img src="{{ asset('storage/'.$r->gambar) }}" alt="{{ $r->judul }}" style="width:100%; height:100%; object-fit:cover;">
                @else
                  <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted small">No Img</div>
                @endif
              </div>
              <div>
                <div class="small text-muted">{{ $r->created_at->format('d M Y') }}</div>
                <a href="{{ url('/apbdesa/'.$r->slug) }}" class="text-decoration-none">{{ $r->judul }}</a>
              </div>
            </div>
          @empty
            <div class="text-muted">Tidak ada data lain.</div>
          @endforelse
        </div>
      </div>
    </div>
  </div>

</div>
@endsection
