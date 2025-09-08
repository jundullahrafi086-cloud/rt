@extends('layouts.main')
@section('content')
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
  
  /* Main Container */
  .main-container {
    background: white;
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    margin: -3rem auto 3rem;
    position: relative;
    z-index: 1;
    padding: 2rem 0;
  }
  
  /* Section Title */
  .section-title {
    text-align: center;
    padding: 3rem 0 2rem;
    position: relative;
  }
  
  .section-title h2 {
    font-size: 3rem;
    font-weight: 700;
    color: #2c3e50;
    margin: 0;
    position: relative;
    display: inline-block;
  }
  
  .section-title h2::after {
    content: '';
    position: absolute;
    bottom: -15px;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 4px;
    background: linear-gradient(90deg, #667eea, #764ba2);
    border-radius: 2px;
  }
  
  .section-subtitle {
    font-size: 1.2rem;
    color: #6c757d;
    margin-top: 1rem;
  }
  
  /* Berita Container */
  .berita-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 2rem;
    padding: 0 3rem 3rem;
  }
  
  /* Card Styles */
  .berita-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    height: 100%;
    display: flex;
    flex-direction: column;
  }
  
  .berita-card::before {
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
  
  .berita-card:hover::before {
    transform: scaleX(1);
  }
  
  .berita-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
  }
  
  /* Image Container */
  .img-container {
    height: 220px;
    overflow: hidden;
    position: relative;
  }
  
  .img-container img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
  }
  
  .berita-card:hover .img-container img {
    transform: scale(1.05);
  }
  
  /* Card Content */
  .card-content {
    padding: 1.5rem;
    flex: 1;
    display: flex;
    flex-direction: column;
  }
  
  .card-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1rem;
  }
  
  .card-icon {
    width: 50px;
    height: 50px;
    border-radius: 15px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.3rem;
    box-shadow: 0 10px 25px rgba(102, 126, 234, 0.2);
    transition: all 0.3s ease;
  }
  
  .berita-card:hover .card-icon {
    transform: scale(1.1) rotate(5deg);
  }
  
  .card-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #2c3e50;
    margin: 0;
    transition: color 0.3s ease;
    line-height: 1.3;
  }
  
  .berita-card:hover .card-title {
    color: #667eea;
  }
  
  .card-meta {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #6c757d;
    font-size: 0.9rem;
    margin-bottom: 1rem;
  }
  
  .card-meta i {
    color: #667eea;
  }
  
  .card-text {
    font-size: 1rem;
    line-height: 1.6;
    color: #495057;
    flex: 1;
  }
  
  .card-text p {
    margin: 0;
  }
  
  /* Card Footer */
  .card-footer {
    margin-top: auto;
    padding-top: 1rem;
    border-top: 1px solid #e9ecef;
  }
  
  .read-more {
    color: #667eea;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
  }
  
  .read-more:hover {
    color: #764ba2;
    gap: 0.8rem;
  }
  
  /* Empty State */
  .empty-state {
    text-align: center;
    padding: 4rem 2rem;
    background: #f8f9fa;
    border-radius: 20px;
    color: #6c757d;
    margin: 0 3rem 3rem;
  }
  
  .empty-state i {
    font-size: 4rem;
    color: #dee2e6;
    margin-bottom: 1rem;
  }
  
  .empty-state h4 {
    color: #495057;
    margin-bottom: 1rem;
  }
  
  .empty-state p {
    margin-bottom: 1.5rem;
  }
  
  /* Pagination */
  .pagination-container {
    padding: 0 3rem 3rem;
    display: flex;
    justify-content: center;
  }
  
  .pagination {
    display: flex;
    gap: 0.5rem;
  }
  
  .page-item .page-link {
    color: #667eea;
    border: 1px solid #e9ecef;
    border-radius: 10px;
    padding: 0.75rem 1rem;
    font-weight: 600;
    transition: all 0.3s ease;
  }
  
  .page-item.active .page-link {
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-color: transparent;
    color: white;
  }
  
  .page-item .page-link:hover {
    background-color: rgba(102, 126, 234, 0.1);
    border-color: #667eea;
    color: #667eea;
  }
  
  /* Responsive */
  @media (max-width: 768px) {
    .berita-container {
      grid-template-columns: 1fr;
      gap: 1.5rem;
      padding: 0 2rem 2rem;
    }
    
    .section-title h2 {
      font-size: 2rem;
    }
    
    .card-icon {
      width: 40px;
      height: 40px;
      font-size: 1.1rem;
    }
    
    .card-title {
      font-size: 1.3rem;
    }
    
    .pagination-container {
      padding: 0 2rem 2rem;
    }
  }
</style>

<!-- Hero Section -->
<div class="hero-section">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-8">
        <h1 class="display-4 fw-bold mb-4" data-aos="fade-right">
          <i class="ti ti-news me-3"></i>Berita Desa
        </h1>
        <p class="lead mb-0" data-aos="fade-right" data-aos-delay="100">
          Informasi terkini dan perkembangan desa. Tetap update dengan berbagai berita, 
          kegiatan, dan prestasi yang dicapai oleh desa kami.
        </p>
      </div>
      <div class="col-lg-4" data-aos="fade-left">
        <img src="{{ asset('images/news-hero.svg') }}" alt="Berita Hero" class="img-fluid">
      </div>
    </div>
  </div>
</div>

<!-- Main Content -->
<div class="main-container" data-aos="fade-up">
  <div class="section-title">
    <h2><i class="ti ti-article me-3"></i>Berita Terbaru</h2>
    <p class="section-subtitle">Informasi dan Perkembangan Desa</p>
  </div>
  
  @if($beritas->count() > 0)
    <div class="berita-container">
      @foreach ($beritas as $berita)
        <div class="berita-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
          <div class="img-container">
            <img src="{{ $berita->gambar ? asset('storage/' . $berita->gambar) : 'https://ui-avatars.com/api/?name=' . urlencode($berita->judul) . '&background=random' }}" 
                 alt="{{ $berita->judul }}"
                 onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($berita->judul) }}&background=random'">
          </div>
          
          <div class="card-content">
            <div class="card-header">
              <div class="card-icon">
                <i class="ti ti-file-text"></i>
              </div>
              <h3 class="card-title">{{ $berita->judul }}</h3>
            </div>
            
            <div class="card-meta">
              <i class="ti ti-calendar me-1"></i>
              <span>{{ $berita->created_at?->format('d F Y') ?? 'Tanggal tidak tersedia' }}</span>
              <i class="ti ti-clock me-1 ms-3"></i>
              <span>{{ $berita->created_at?->diffForHumans() ?? 'Baru saja' }}</span>
            </div>
            
            <div class="card-text">
              <p>{{ $berita->excerpt }}</p>
            </div>
            
            <div class="card-footer">
              <a href="/berita/{{ $berita->slug }}" class="read-more">
                Baca Selengkapnya <i class="ti ti-arrow-right"></i>
              </a>
            </div>
          </div>
        </div>
      @endforeach
    </div>
    
    <div class="pagination-container">
      {{ $beritas->links() }}
    </div>
  @else
    <div class="empty-state" data-aos="fade-up">
      <i class="ti ti-news-off"></i>
      <h4>Belum ada Berita</h4>
      <p>Belum ada berita yang dipublikasikan. Silakan periksa kembali beberapa saat lagi.</p>
      <a href="{{ route('home') }}" class="btn btn-primary">
        <i class="ti ti-home me-2"></i>Kembali ke Beranda
      </a>
    </div>
  @endif
</div>
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
  
  // Add hover effects to cards
  const cards = document.querySelectorAll('.berita-card');
  cards.forEach(card => {
    card.addEventListener('mouseenter', function() {
      this.style.transform = 'translateY(-10px)';
    });
    
    card.addEventListener('mouseleave', function() {
      this.style.transform = 'translateY(0)';
    });
  });
  
  // Add rotation effect to icons on hover
  const icons = document.querySelectorAll('.card-icon');
  icons.forEach(icon => {
    icon.addEventListener('mouseenter', function() {
      this.style.transform = 'scale(1.1) rotate(5deg)';
    });
    
    icon.addEventListener('mouseleave', function() {
      this.style.transform = 'scale(1) rotate(0deg)';
    });
  });
});
</script>
@endpush

@push('styles')
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet"/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons@latest/iconfont/tabler-icons.min.css">
@endpush