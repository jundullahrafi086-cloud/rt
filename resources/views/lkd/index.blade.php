{{-- CSS untuk animasi dan hover effect --}}
@push('styles')
<style>
  .card-hover {
    transition: transform 0.2s ease-in-out, box-shadow 0.3s ease-in-out;
  }
  .card-hover:hover {
    transform: translateY(-5px);
    box-shadow: 0 1rem 1.5rem rgba(0,0,0,.15) !important; /* Bayangan lebih kuat saat hover */
  }
  .text-line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  /* CSS UNTUK ANIMASI SCROLL */
  .fade-in-card {
    opacity: 0;
    transform: translateY(40px);
    transition: opacity 0.5s ease-out, transform 0.6s ease-out;
  }

  .fade-in-card.visible {
    opacity: 1;
    transform: translateY(0);
  }
</style>
@endpush


@extends('layouts.main')

@section('title', 'LKD')

@section('content')
<div class="container py-4 py-md-5">

  {{-- BAGIAN JUDUL --}}
  <div class="row mb-5">
    <div class="col text-center">
      <h1 class="h2 mb-1 fw-bold">Lembaga & Kelompok Desa</h1>
      <p class="text-muted">Daftar lembaga dan kelompok yang aktif di desa kami.</p>
    </div>
  </div>

  @if($items->isEmpty())
    {{-- TAMPILAN JIKA DATA KOSONG --}}
    <div class="text-center py-5">
      <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-folder-x text-muted mb-3" viewBox="0 0 16 16">
        <path d="M.54 3.87.5 3a2 2 0 0 1 2-2h3.672a2 2 0 0 1 1.414.586l.828.828A2 2 0 0 0 9.828 3h3.982a2 2 0 0 1 1.992 2.181L15.546 8H14.54l.265-2.91A1 1 0 0 0 13.81 4H9.828a1 1 0 0 1-.707-.293L8.293 2.854A1 1 0 0 0 7.586 2.5H2.5A1 1 0 0 0 1.5 3.5v11A1.5 1.5 0 0 0 3 16h10a1.5 1.5 0 0 0 1.5-1.5V9.932l.259.311.23.275-1.017 1.018a.5.5 0 0 0 .708.707l1.018-1.017.275.23.31.259V14.5A2.5 2.5 0 0 1 13 17H3a2.5 2.5 0 0 1-2.5-2.5V3.87zM8.472 5.432a.5.5 0 0 0-.707-.707l-1.25 1.25-1.25-1.25a.5.5 0 0 0-.707.707L7.043 6.14 5.793 7.39a.5.5 0 1 0 .707.707l1.25-1.25 1.25 1.25a.5.5 0 0 0 .707-.707L8.472 6.14 9.722 4.89z"/>
      </svg>
      <h3 class="h5">Belum Ada Data</h3>
      <p class="text-muted">Saat ini belum ada Lembaga/Kelompok Desa yang dipublikasikan.</p>
    </div>
  @else
    {{-- DAFTAR LEMBAGA/KELOMPOK --}}
    <div class="row g-4 justify-content-center">
      @foreach($items as $lkd)
        {{-- Tambahkan kelas .fade-in-card di sini --}}
        <div class="col-12 col-md-6 col-lg-4 d-flex fade-in-card"> 
          {{-- Ubah shadow-sm menjadi shadow --}}
          <div class="card h-100 shadow-lg card-hover w-100">
            <a href="{{ route('lkd.show', $lkd) }}" class="text-decoration-none">
              <img
                src="{{ $lkd->cover_url }}"
                alt="{{ $lkd->judul }}"
                class="card-img-top"
                style="height:200px; object-fit:cover;"
                onerror="this.src='{{ asset('images/placeholders/Bpd.png') }}';"
              >
            </a>
            <div class="card-body d-flex flex-column">
              <h2 class="h5 card-title mb-2">
                <a href="{{ route('lkd.show', $lkd) }}" class="text-decoration-none text-dark">
                  {{ $lkd->judul }}
                </a>
              </h2>
              @if(!empty($lkd->excerpt))
                <p class="card-text text-muted small text-line-clamp-2">{{ $lkd->excerpt }}</p>
              @endif
              <div class="mt-auto pt-3 d-flex align-items-center justify-content-between">
                <small class="text-muted">
                  {{ optional($lkd->updated_at)->format('d M Y') }}
                </small>
                <a href="{{ route('lkd.show', $lkd) }}" class="btn btn-sm btn-primary">
                  Lihat Detail <i class="bi bi-arrow-right-short"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>

    {{-- PAGINASI --}}
    @if ($items->hasPages())
      <div class="mt-5 d-flex justify-content-center">
        {{ $items->links() }}
      </div>
    @endif
  @endif
</div>
@endsection


{{-- JAVASCRIPT UNTUK ANIMASI SCROLL --}}
@push('scripts')
<script>
  document.addEventListener("DOMContentLoaded", function() {
    // Opsi untuk Intersection Observer
    const observerOptions = {
      root: null, // Menggunakan viewport sebagai root
      rootMargin: "0px",
      threshold: 0.1 // Memicu animasi saat 10% elemen terlihat
    };

    // Callback function yang dijalankan saat elemen terdeteksi
    const observerCallback = (entries, observer) => {
      entries.forEach(entry => {
        // Jika elemen masuk ke dalam viewport
        if (entry.isIntersecting) {
          entry.target.classList.add('visible'); // Tambahkan kelas 'visible'
          observer.unobserve(entry.target); // Hentikan pengamatan setelah animasi berjalan
        }
      });
    };

    // Buat observer baru
    const observer = new IntersectionObserver(observerCallback, observerOptions);

    // Ambil semua elemen kartu dan mulai amati
    const elementsToAnimate = document.querySelectorAll('.fade-in-card');
    elementsToAnimate.forEach(el => {
      observer.observe(el);
    });
  });
</script>
@endpush