@extends('layouts.main')

@section('content')
<section id="hero">
  <div class="hero-container">
    <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">

      <ol class="carousel-indicators" id="hero-carousel-indicators"></ol>

      <div class="carousel-inner" role="listbox">
        @foreach ($sliders as $key => $slider)
        <div class="carousel-item{{ $key === 0 ? ' active' : '' }}"
             style="background-image: url({{ asset('storage/' . $slider->img_slider) }});">
          <div class="carousel-container">
            <div class="carousel-content container">
              <h2 class="animate__animated animate__fadeInDown">{{ $slider->judul }}</h2>
              <p class="animate__animated animate__fadeInUp">{{ $slider->deskripsi }}</p>
              @if(!empty($slider->link_btn))
                <a href="{{ $slider->link_btn }}" class="btn-get-started animate__animated animate__fadeInUp">Baca Selengkapnya</a>
              @endif
            </div>
          </div>
        </div>
        @endforeach
      </div>

      <a class="carousel-control-prev" href="#heroCarousel" role="button" data-bs-slide="prev">
        <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
      </a>
      <a class="carousel-control-next" href="#heroCarousel" role="button" data-bs-slide="next">
        <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
      </a>

    </div>
  </div>
</section><!-- End Hero -->

<!-- ======= Services Section ======= -->
<section id="services" class="services">
  <div class="container" data-aos="fade-up">

    <div class="row g-3">
      <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="0">
        <a href="{{ url('data-desa') }}" class="text-decoration-none d-block h-100">
          <div class="icon-box h-100">
            <div class="icon"><i class="bi bi-bar-chart-line-fill"></i></div>
            <h4 class="title mb-0">Statistik</h4>
          </div>
        </a>
      </div>

      <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
        <a href="{{ url('peta-desa') }}" class="text-decoration-none d-block h-100">
          <div class="icon-box h-100">
            <div class="icon"><i class="bi bi-globe-asia-australia"></i></div>
            <h4 class="title mb-0">Peta Desa</h4>
          </div>
        </a>
      </div>

      <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
        <a href="{{ url('umkm') }}" class="text-decoration-none d-block h-100">
          <div class="icon-box h-100">
            <div class="icon"><i class="bi bi-shop"></i></div>
            <h4 class="title mb-0">UMKM Desa</h4>
          </div>
        </a>
      </div>

      <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
        <a href="{{ url('kontak') }}" class="text-decoration-none d-block h-100">
          <div class="icon-box h-100">
            <div class="icon"><i class="bi bi-telephone-forward"></i></div>
            <h4 class="title mb-0">Pengaduan</h4>
          </div>
        </a>
      </div>
    </div>

  </div>
</section>

<!-- ======= Video Section ======= -->
<section id="video" class="services mx-4">
  <div class="container" data-aos="fade-up">
    <div class="section-title">
      <h2>Video Profile</h2>
    </div>

    <div class="row">
      <div class="col-lg-10 mx-auto" data-aos="fade-up">
        <iframe width="100%" height="500" src="{{ $videoProfil->url_video }}" frameborder="0" allowfullscreen></iframe>
      </div>
    </div>
  </div>
</section>

<section class="counts section-bg">
  <div class="container">

    <div class="section-title">
      <h2>Berita Desa</h2>
    </div>

    <div class="row">
      @foreach ($beritas as $berita)
        <div class="col-lg-4 col-md-6 mb-3" 
             data-aos="fade-up" 
             data-aos-delay="{{ ($loop->index % 6) * 100 }}">
          <div class="count-box news-card">
            <div class="card h-100">
              <img src="{{ asset('storage/' . $berita->gambar) }}" loading="lazy" alt="Gambar Berita" class="card-img-top">
              <div class="card-body">
                <h5 class="card-title">{{ $berita->judul }}</h5>
                <p class="card-text">{{ $berita->excerpt }}</p>
                <div class="news-date">{{ $berita->created_at->diffForHumans() }}</div>
              </div>
              <div class="card-footer">
                <a href="/berita/{{ $berita->slug }}" type="button" class="btn btn-link float-end">Selengkapnya</a>
              </div>
            </div>
          </div>
        </div>
      @endforeach

      <div class="button" style="text-align: center">
        <a class="btn btn-primary mx-auto" href="/berita" role="button">Lihat Semua</a>
      </div>
    </div>

  </div>
</section>
@endsection

@push('scripts')
<!-- AOS init -->
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    AOS.init({
      once: false,       // biar animasi bisa muncul lagi
      mirror: true,      // biar saat scroll ke atas juga animasi lagi
      duration: 650,
      easing: 'ease-out-cubic',
      offset: 80,
      anchorPlacement: 'top-bottom'
    });
    window.addEventListener('load', () => AOS.refresh());
  });
</script>
@endpush
