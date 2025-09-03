@extends('admin.layouts.main')

@section('content')
<div class="container-fluid py-3">

  {{-- Notifikasi sukses --}}
  @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  {{-- Header --}}
  <div class="card shadow-lg mb-4">
    <div class="card-header bg-primary text-white">
      <div class="d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Kelola Slider</h4>
        <a href="{{ route('slider.create') }}" class="btn btn-light">+ Tambah Slide</a>
      </div>
    </div>
  </div>

  {{-- Daftar Slider --}}
  <div class="card shadow-lg">
    <div class="card-header">
      <strong>Daftar Slider</strong>
    </div>
    <div class="card-body">
      @if($sliders->isEmpty())
        <div class="text-muted">Belum ada data slider.</div>
      @else
        <div class="row g-4">
          @foreach($sliders as $slider)
            <div class="col-md-4">
              <div class="card h-100 shadow-lg border-2 slider-card">
                {{-- Gambar slider --}}
                <div class="ratio ratio-16x9 overflow-hidden">
                  <img src="{{ asset('storage/'.$slider->img_slider) }}"
                       alt="slider"
                       class="img-fluid rounded-top slider-img"
                       style="object-fit: cover;">
                </div>

                {{-- Isi card --}}
                <div class="card-body d-flex flex-column">
                  <h5 class="card-title mb-2 fw-semibold">{{ $slider->judul }}</h5>
                  <p class="card-text text-muted small mb-3" style="min-height: 48px;">
                    {{ \Illuminate\Support\Str::limit($slider->deskripsi, 110) }}
                  </p>

                  <div class="mt-auto d-flex gap-2 flex-wrap">
                    <a href="{{ url('/admin/slider/'.$slider->id.'/edit') }}" class="btn btn-warning btn-sm">Edit</a>

                    <form action="{{ url('/admin/slider/'.$slider->id) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Hapus slide ini?')">
                      @csrf @method('DELETE')
                      <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
                    </form>

                    @if(!empty($slider->link_btn))
                      <a href="{{ $slider->link_btn }}" class="btn btn-info btn-sm" target="_blank">Lihat Link</a>
                    @endif
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      @endif
    </div>
  </div>
</div>

{{-- CSS tambahan untuk efek zoom --}}
<style>
  .slider-card {
    transition: transform .3s ease, box-shadow .3s ease;
  }
  .slider-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 24px rgba(0,0,0,0.25);
  }

  .slider-img {
    transition: transform .5s ease;
  }
  .slider-card:hover .slider-img {
    transform: scale(1.1);
  }
</style>
@endsection
