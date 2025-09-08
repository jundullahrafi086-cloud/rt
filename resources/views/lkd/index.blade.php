@extends('layouts.main')
@section('title','Lembaga Kemasyarakatan Desa (LKD)')
@section('content')
@php
  // Helper function untuk menampilkan foto (sesuai pola sebelumnya)
  function getPhotoUrl($path, $placeholder = 'https://via.placeholder.com/400x300?text=Cover+LKD') {
    return $path ? asset('storage/' . $path) : $placeholder;
  }
@endphp
<style>
  /* Hero Section */
  .hero-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 4rem 0;
    margin-bottom: 3rem;
    border-radius: 0 0 50px 0;
    position: relative;
    overflow: hidden;
  }
  
  .hero-section::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    animation: float 20s infinite linear;
  }
  
  @keyframes float {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }
  
  /* Card Styles */
  .lkd-card {
    border: none;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    background: white;
    position: relative;
    height: 100%;
    display: flex;
    flex-direction: column;
  }
  
  .lkd-card:hover {
    transform: translateY(-15px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
  }
  
  .lkd-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 5px;
    background: linear-gradient(90deg, #667eea, #764ba2);
    transform: scaleX(0);
    transition: transform 0.3s ease;
  }
  
  .lkd-card:hover::before {
    transform: scaleX(1);
  }
  
  .lkd-card .card-img-top {
    height: 220px;
    object-fit: cover;
    transition: transform 0.5s ease;
  }
  
  .lkd-card:hover .card-img-top {
    transform: scale(1.05);
  }
  
  .lkd-card .card-body {
    padding: 1.5rem;
    flex: 1;
    display: flex;
    flex-direction: column;
  }
  
  .lkd-card .card-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 0.75rem;
    transition: color 0.3s ease;
  }
  
  .lkd-card:hover .card-title {
    color: #667eea;
  }
  
  .lkd-card .card-text {
    color: #6c757d;
    font-size: 0.95rem;
    line-height: 1.6;
    margin-bottom: 1rem;
    flex: 1;
  }
  
  .lkd-card .btn-primary {
    background: linear-gradient(45deg, #667eea, #764ba2);
    border: none;
    border-radius: 25px;
    padding: 0.5rem 1.5rem;
    font-weight: 600;
    transition: all 0.3s ease;
  }
  
  .lkd-card .btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
  }
  
  /* Badge Styles */
  .lkd-badge {
    position: absolute;
    top: 15px;
    right: 15px;
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(10px);
    color: #495057;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    z-index: 2;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
  }
  
  /* Empty State */
  .empty-state {
    text-align: center;
    padding: 4rem 2rem;
    color: #6c757d;
  }
  
  .empty-state i {
    font-size: 4rem;
    color: #dee2e6;
    margin-bottom: 1rem;
  }
  
  /* Pagination Styles */
  .pagination {
    margin-top: 3rem;
  }
  
  .page-link {
    border: none;
    color: #667eea;
    margin: 0 3px;
    border-radius: 10px;
    padding: 0.75rem 1rem;
    transition: all 0.3s ease;
  }
  
  .page-item.active .page-link {
    background: linear-gradient(45deg, #667eea, #764ba2);
    border: none;
  }
  
  .page-link:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
  }
  
  /* Stats Section */
  .stats-section {
    background: #f8f9fa;
    padding: 3rem 0;
    margin-bottom: 3rem;
    border-radius: 20px;
  }
  
  .stat-card {
    background: white;
    padding: 2rem;
    border-radius: 15px;
    text-align: center;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
  }
  
  .stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
  }
  
  .stat-card i {
    font-size: 3rem;
    color: #667eea;
    margin-bottom: 1rem;
  }
  
  .stat-card h3 {
    font-size: 2rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 0.5rem;
  }
  
  /* Filter Section */
  .filter-section {
    background: white;
    padding: 1.5rem;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
    margin-bottom: 2rem;
  }
  
  .filter-btn {
    border: 2px solid #e9ecef;
    background: white;
    color: #6c757d;
    border-radius: 25px;
    padding: 0.5rem 1.5rem;
    margin: 0.25rem;
    transition: all 0.3s ease;
  }
  
  .filter-btn:hover, .filter-btn.active {
    background: linear-gradient(45deg, #667eea, #764ba2);
    border-color: transparent;
    color: white;
    transform: translateY(-2px);
  }
</style>

<!-- Hero Section -->
<div class="hero-section">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-6">
        <h1 class="display-4 fw-bold mb-4" data-aos="fade-right">
          Lembaga Kemasyarakatan Desa
        </h1>
        <p class="lead mb-4" data-aos="fade-right" data-aos-delay="100">
          Mengenal lebih dekat berbagai lembaga kemasyarakatan yang aktif di desa kami. 
          Dari BPD hingga PKK, semua bekerja sama untuk membangun desa yang lebih baik.
        </p>
        
      </div>
      
    </div>
  </div>
</div>

<!-- Stats Section -->
<div class="stats-section">
  <div class="container">
    <div class="row g-4">
      <div class="col-md-3" data-aos="fade-up" data-aos-delay="100">
        <div class="stat-card">
          <i class="ti ti-building"></i>
          <h3>{{ $items->total() }}</h3>
          <p>Total LKD</p>
        </div>
      </div>
      <div class="col-md-3" data-aos="fade-up" data-aos-delay="200">
        <div class="stat-card">
          <i class="ti ti-users"></i>
          <h3>{{ App\Models\LkdMember::count() }}</h3>
          <p>Total Anggota</p>
        </div>
      </div>
      <div class="col-md-3" data-aos="fade-up" data-aos-delay="300">
        <div class="stat-card">
          <i class="ti ti-check"></i>
          <h3>{{ App\Models\Lkd::where('published', true)->count() }}</h3>
          <p>LKD Aktif</p>
        </div>
      </div>
      <div class="col-md-3" data-aos="fade-up" data-aos-delay="400">
        <div class="stat-card">
          <i class="ti ti-calendar"></i>
          <h3>{{ \Carbon\Carbon::now()->format('Y') }}</h3>
          <p>Tahun Aktif</p>
        </div>
      </div>
    </div>
  </div>
</div>



<!-- LKD List Section -->
<div class="container" id="lkd-list">
  <h2 class="text-center mb-5" data-aos="fade-up">
    <i class="ti ti-building me-3"></i>Daftar LKD Aktif
  </h2>
  
  <div class="row g-4">
    @forelse($items as $lkd)
      <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
        <div class="lkd-card">
          <!-- Badge Status -->
          <span class="lkd-badge">
            <i class="ti ti-circle-filled me-1"></i>{{ $lkd->published ? 'Aktif' : 'Draft' }}
          </span>
          
          <!-- Cover Image - PERBAIKAN DISINI -->
          @if($lkd->cover_path)
            <img src="{{ getPhotoUrl($lkd->cover_path, 'https://via.placeholder.com/400x300?text=Cover+LKD') }}" 
                 class="card-img-top" 
                 alt="{{ $lkd->judul }}">
          @else
            <div class="card-img-top bg-light d-flex align-items-center justify-content-center">
              <i class="ti ti-photo-off" style="font-size: 3rem; color: #dee2e6;"></i>
            </div>
          @endif
          
          <!-- Card Body -->
          <div class="card-body">
            <h5 class="card-title">{{ $lkd->judul }}</h5>
            <p class="card-text">
              {{ \Illuminate\Support\Str::limit(strip_tags($lkd->deskripsi), 120) }}
            </p>
            
            <!-- Meta Info -->
            <div class="d-flex justify-content-between align-items-center mb-3">
              <span class="text-muted small">
                <i class="ti ti-users me-1"></i>
                {{ $lkd->members()->count() }} Anggota
              </span>
              <span class="text-muted small">
                <i class="ti ti-calendar me-1"></i>
                {{ optional($lkd->updated_at)->format('d M Y') }}
              </span>
            </div>
            
            <!-- Action Button -->
            <a href="{{ route('lkd.show',$lkd) }}" class="btn btn-primary w-100">
              <i class="ti ti-eye me-2"></i>Lihat Detail
            </a>
          </div>
        </div>
      </div>
    @empty
      <div class="col-12">
        <div class="empty-state" data-aos="fade-up">
          <i class="ti ti-building-community"></i>
          <h4>Belum ada data LKD</h4>
          <p class="text-muted">Data lembaga kemasyarakatan desa belum tersedia.</p>
          <a href="{{ route('home') }}" class="btn btn-primary">
            <i class="ti ti-home me-2"></i>Kembali ke Beranda
          </a>
        </div>
      </div>
    @endforelse
  </div>
  
  <!-- Pagination -->
  @if($items->hasPages())
    <div class="d-flex justify-content-center" data-aos="fade-up" data-aos-delay="200">
      {{ $items->links() }}
    </div>
  @endif
</div>

<!-- Back to Top Button -->
<button id="backToTop" class="btn btn-primary btn-lg position-fixed bottom-0 end-0 m-3" style="display: none;">
  <i class="ti ti-arrow-up"></i>
</button>
@endsection

@push('scripts')
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Initialize AOS
  AOS.init({
    duration: 800,
    easing: 'ease-in-out',
    once: true
  });

  // Filter functionality
  

  // Back to top button
  const backToTopButton = document.getElementById('backToTop');
  
  window.addEventListener('scroll', function() {
    if (window.pageYOffset > 300) {
      backToTopButton.style.display = 'block';
    } else {
      backToTopButton.style.display = 'none';
    }
  });
  
  backToTopButton.addEventListener('click', function() {
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  });

  // Add hover effect to cards
  const cards = document.querySelectorAll('.lkd-card');
  cards.forEach(card => {
    card.addEventListener('mouseenter', function() {
      this.style.transform = 'translateY(-15px)';
    });
    
    card.addEventListener('mouseleave', function() {
      this.style.transform = 'translateY(0)';
    });
  });
});
</script>
@endpush

@push('styles')
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
@endpush