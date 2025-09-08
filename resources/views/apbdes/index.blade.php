@extends('layouts.main')

@section('content')
<section class="py-5 bg-light">
  <div class="container">
    {{-- Header --}}
    <div class="text-center mb-4">
      <h2 class="fw-bold mb-1">APBDesa</h2>
      <p class="text-muted mb-0">Laporan Anggaran Pendapatan dan Belanja Desa</p>
    </div>

    {{-- Grid --}}
    <div class="row g-4">
      @forelse ($items as $row)
        <div class="col-12 col-sm-6 col-lg-4">
          <div class="card h-100 border-0 shadow-sm hover-shadow transition">
            {{-- Cover image (rasio seragam) --}}
            <div class="ratio ratio-16x9">
              @if($row->gambar_url)
                <img src="{{ asset('storage/'.$row->gambar) }}" alt="Cover {{ $row->judul }}" class="img-fluid" style="object-fit:cover;">
              @else
                <img src="{{ asset('images/default-apbdes.jpg') }}" class="rounded-top object-fit-cover" alt="Cover default">
              @endif
            </div>

            {{-- Body --}}
            <div class="card-body d-flex flex-column">
              <h5 class="card-title fw-semibold mb-2 text-truncate" title="{{ $row->judul }}">
                {{ $row->judul }}
              </h5>

              <p class="text-muted small mb-3 clamp-2">
                {{ \Illuminate\Support\Str::limit(strip_tags($row->deskripsi), 140) }}
              </p>

              {{-- Aksi --}}
              <div class="d-grid gap-2 mt-auto">
                <a href="{{ route('apbdesa.detail', $row->slug) }}" class="btn btn-primary">
                  <i class="bi bi-eye"></i> Detail
                </a>

                @if(!empty($row->dokumen_path))
                  <div class="d-flex gap-2">
                    <a href="{{ route('apbdes.open', $row->slug) }}" target="_blank" class="btn btn-outline-secondary flex-fill">
                      <i class="bi bi-box-arrow-up-right"></i> Buka
                    </a>
                    <a href="{{ route('apbdesa.download', $row->slug) }}" class="btn btn-outline-secondary flex-fill">
                      <i class="bi bi-download"></i> Unduh
                    </a>
                  </div>
                @endif
              </div>
            </div>

            {{-- Footer info --}}
            <div class="card-footer bg-white border-0 pt-0 pb-3">
              <span class="badge bg-light text-secondary border small">
                Diperbarui {{ $row->updated_at?->format('d M Y') }}
              </span>
              @if(!empty($row->dokumen_original))
                <span class="text-muted small ms-2 d-inline-block text-truncate" style="max-width: 55%;">
                  <i class="bi bi-file-earmark-text"></i> {{ \Illuminate\Support\Str::limit($row->dokumen_original, 28) }}
                </span>
              @endif
            </div>
          </div>
        </div>
      @empty
        <div class="col-12">
          <div class="alert alert-info text-center mb-0">
            Belum ada data APBDes. Silakan kembali lagi nanti.
          </div>
        </div>
      @endforelse
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center mt-4">
      {{ $items->links() }}
    </div>
  </div>
</section>

{{-- Utilitas kecil untuk rapikan teks & hover --}}
<style>
  .object-fit-cover { object-fit: cover; }
  .hover-shadow:hover { box-shadow: 0 .5rem 1rem rgba(0,0,0,.08)!important; transform: translateY(-2px); }
  .transition { transition: all .15s ease-in-out; }
  .clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2; /* jumlah baris */
    -webkit-box-orient: vertical;
    overflow: hidden;
  }
</style>
@endsection
