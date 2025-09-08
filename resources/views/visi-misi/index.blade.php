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
  
  /* Visi Misi Container */
  .visi-misi-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(500px, 1fr));
    gap: 3rem;
    padding: 3rem;
  }
  
  /* Card Styles */
  .vision-mission-card {
    background: white;
    border-radius: 20px;
    padding: 3rem;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    height: 100%;
    display: flex;
    flex-direction: column;
  }
  
  .vision-mission-card::before {
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
  
  .vision-mission-card:hover::before {
    transform: scaleX(1);
  }
  
  .vision-mission-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
  }
  
  /* Card Header */
  .card-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 2rem;
  }
  
  .card-icon {
    width: 60px;
    height: 60px;
    border-radius: 20px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    box-shadow: 0 10px 25px rgba(102, 126, 234, 0.2);
    transition: all 0.3s ease;
  }
  
  .vision-mission-card:hover .card-icon {
    transform: scale(1.1) rotate(5deg);
  }
  
  .card-title {
    font-size: 1.8rem;
    font-weight: 700;
    color: #2c3e50;
    margin: 0;
    transition: color 0.3s ease;
  }
  
  .vision-mission-card:hover .card-title {
    color: #667eea;
  }
  
  /* Card Content */
  .card-content {
    flex: 1;
  }
  
  .card-text {
    font-size: 1.1rem;
    line-height: 1.8;
    color: #495057;
    margin-bottom: 2rem;
  }
  
  .card-text p {
    margin: 0;
  }
  
  /* Card Footer */
  .card-footer {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding-top: 1.5rem;
    border-top: 1px solid #e9ecef;
  }
  
  .card-meta {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #6c757d;
    font-size: 0.9rem;
  }
  
  .card-meta i {
    color: #667eea;
  }
  
  /* Badge */
  .card-badge {
    background: linear-gradient(45deg, #667eea, #764ba2);
    color: white;
    padding: 0.4rem 1rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.2);
  }
  
  /* Empty State */
  .empty-state {
    text-align: center;
    padding: 4rem 2rem;
    background: #f8f9fa;
    border-radius: 20px;
    color: #6c757d;
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
  
  /* Responsive */
  @media (max-width: 768px) {
    .visi-misi-container {
      grid-template-columns: 1fr;
      gap: 2rem;
      padding: 2rem;
    }
    
    .section-title h2 {
      font-size: 2rem;
    }
    
    .vision-mission-card {
      padding: 2rem;
    }
    
    .card-icon {
      width: 50px;
      height: 50px;
      font-size: 1.2rem;
    }
    
    .card-title {
      font-size: 1.5rem;
    }
  }
</style>

<!-- Hero Section -->
<div class="hero-section">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-8">
        <h1 class="display-4 fw-bold mb-4" data-aos="fade-right">
          <i class="ti ti-bulb me-3"></i>Visi & Misi Desa
        </h1>
        <p class="lead mb-0" data-aos="fade-right" data-aos-delay="100">
          Mengetahui visi dan misi yang menjadi pedoman dalam pembangunan desa. 
          Panduan strategis untuk mewujudkan desa yang lebih baik untuk masa depan.
        </p>
      </div>
      <div class="col-lg-4" data-aos="fade-left">
        <img src="{{ asset('images/vision-mission-hero.svg') }}" alt="Visi Misi Hero" class="img-fluid">
      </div>
    </div>
  </div>
</div>

<!-- Main Content -->
<div class="main-container" data-aos="fade-up">
  <div class="section-title">
    <h2><i class="ti ti-target me-3"></i>Visi & Misi Desa</h2>
    <p class="section-subtitle">Pedoman Pembangunan Desa</p>
  </div>
  
  @if($visiMisi)
    <div class="visi-misi-container">
      <!-- Vision Card -->
      <div class="vision-mission-card" data-aos="fade-up" data-aos-delay="100">
        <div class="card-header">
          <div class="card-icon">
            <i class="ti ti-eye"></i>
          </div>
          <h3 class="card-title">Visi</h3>
        </div>
        
        <div class="card-content">
          <div class="card-text">
            {!! $visiMisi->visi !!}
          </div>
        </div>
        
        <div class="card-footer">
          <div class="card-meta">
            <i class="ti ti-calendar me-1"></i>
            <span>Diperbarui {{ $visiMisi->created_at->format('d F Y') }}</span>
          </div>
          <div class="card-badge">
            TUJUAN
          </div>
        </div>
      </div>
      
      <!-- Mission Card -->
      <div class="vision-mission-card" data-aos="fade-up" data-aos-delay="200">
        <div class="card-header">
          <div class="card-icon">
            <i class="ti ti-flag"></i>
          </div>
          <h3 class="card-title">Misi</h3>
        </div>
        
        <div class="card-content">
          <div class="card-text">
            {!! $visiMisi->misi !!}
          </div>
        </div>
        
        <div class="card-footer">
          <div class="card-meta">
            <i class="ti ti-refresh me-1"></i>
            <span>Diperbarui {{ $visiMisi->updated_at->format('d F Y') }}</span>
          </div>
          <div class="card-badge">
            AKSI
          </div>
        </div>
      </div>
    </div>
  @else
    <div class="empty-state" data-aos="fade-up">
      <i class="ti ti-target-off"></i>
      <h4>Belum ada data Visi & Misi</h4>
      <p>Visi dan misi desa belum ditetapkan. Silakan tambahkan data visi dan misi untuk menjadi pedoman pembangunan.</p>
      <a href="{{ route('visi-misi.create') }}" class="btn btn-primary">
        <i class="ti ti-plus me-2"></i>Tambah Visi & Misi
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
  const cards = document.querySelectorAll('.vision-mission-card');
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
@endpush