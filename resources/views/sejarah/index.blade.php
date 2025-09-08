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
  
  /* Content Section */
  .content-section {
    background: white;
    border-radius: 20px;
    padding: 3rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    margin-bottom: 3rem;
    position: relative;
  }
  
  .content-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 5px;
    background: linear-gradient(90deg, #667eea, #764ba2);
    border-radius: 20px 20px 0 0;
  }
  
  .content-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 1rem;
    position: relative;
    display: inline-block;
  }
  
  .content-title::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 0;
    width: 60px;
    height: 4px;
    background: linear-gradient(45deg, #667eea, #764ba2);
    border-radius: 2px;
  }
  
  .content-body {
    font-size: 1.1rem;
    line-height: 1.8;
    color: #495057;
  }
  
  /* Timeline Section */
  .timeline-section {
    background: #f8f9fa;
    border-radius: 20px;
    padding: 3rem;
    margin-bottom: 3rem;
    position: relative;
  }
  
  .timeline-header {
    display: flex;
    align-items-center center;
    margin-bottom: 2.5rem;
  }
  
  .timeline-title {
    font-size: 2rem;
    font-weight: 600;
    color: #2c3e50;
    margin: 0;
  }
  
  .timeline-subtitle {
    color: #6c757d;
    font-size: 1.1rem;
    margin-left: 1rem;
  }
  
  .timeline {
    position: relative;
    padding-left: 2rem;
  }
  
  .timeline::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 3px;
    background: linear-gradient(180deg, #667eea, #764ba2);
    border-radius: 3px;
  }
  
  .timeline-item {
    position: relative;
    padding-bottom: 2rem;
    margin-left: 2rem;
    transition: all 0.3s ease;
  }
  
  .timeline-item:last-child {
    padding-bottom: 0;
  }
  
  .timeline-item::before {
    content: '';
    position: absolute;
    left: -2.75rem;
    top: 1.5rem;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: white;
    border: 4px solid #667eea;
    box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.3);
    z-index: 1;
    transition: all 0.3s ease;
  }
  
  .timeline-item:hover::before {
    transform: scale(1.2);
    box-shadow: 0 0 0 8px rgba(102, 126, 234, 0.5);
  }
  
  .timeline-card {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    display: flex;
    gap: 2rem;
    align-items: center;
  }
  
  .timeline-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
  }
  
  /* Photo Container */
  .photo-container {
    flex-shrink: 0;
    position: relative;
  }
  
  .photo-wrapper {
    width: 120px;
    height: 120px;
    border-radius: 20px;
    overflow: hidden;
    background: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
  }
  
  .timeline-card:hover .photo-wrapper {
    transform: scale(1.05);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
  }
  
  .photo-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
  
  .photo-icon {
    font-size: 3rem;
    color: #dee2e6;
  }
  
  /* Info Container */
  .info-container {
    flex-grow: 1;
  }
  
  .info-header {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1rem;
  }
  
  .info-name {
    font-size: 1.3rem;
    font-weight: 700;
    color: #2c3e50;
    margin: 0;
  }
  
  .periode-badge {
    background: linear-gradient(45deg, #667eea, #764ba2);
    color: white;
    padding: 0.4rem 1rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.2);
  }
  
  .info-catatan {
    color: #6c757d;
    font-size: 1rem;
    line-height: 1.6;
    margin: 0;
  }
  
  /* Empty State */
  .empty-state {
    text-align: center;
    padding: 4rem 2rem;
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
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
    color: #6c757d;
    margin-bottom: 1.5rem;
  }
  
  /* Alert Styles */
  .alert-custom {
    border: none;
    border-radius: 15px;
    padding: 1.5rem;
    margin-bottom: 2rem;
  }
  
  .alert-info {
    background: linear-gradient(135deg, #d1ecf1, #667eea);
    color: #0c5460;
  }
  
  .alert-warning {
    background: linear-gradient(135deg, #fff3cd, #ffc107);
    color: #664d03;
  }
  
  /* Responsive */
  @media (max-width: 768px) {
    .timeline-card {
      flex-direction: column;
      text-align: center;
      gap: 1.5rem;
    }
    
    .photo-wrapper {
      width: 100px;
      height: 100px;
      margin: 0 auto;
    }
    
    .info-header {
      justify-content: center;
    }
    
    .content-section,
    .timeline-section {
      padding: 2rem;
    }
  }
</style>

<!-- Hero Section -->
<div class="hero-section">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-8">
        <h1 class="display-4 fw-bold mb-4" data-aos="fade-right">
          <i class="ti ti-history me-3"></i>Sejarah Kepemimpinan Desa
        </h1>
        <p class="lead mb-0" data-aos="fade-right" data-aos-delay="100">
          Menelusuri perjalanan sejarah kepemimpinan desa dari masa ke masa. 
          Dari para pendiri hingga pemimpin saat ini, semua telah berkontribusi dalam membangun desa kita.
        </p>
      </div>
      <div class="col-lg-4" data-aos="fade-left">
        <img src="{{ asset('images/sejarah-hero.svg') }}" alt="Sejarah Hero" class="img-fluid">
      </div>
    </div>
  </div>
</div>

<div class="container">
  <!-- Artikel/Body Sejarah -->
  @if($sejarah)
    <div class="content-section" data-aos="fade-up">
      <h2 class="content-title">
        <i class="ti ti-book me-3"></i>{{ $sejarah->judul }}
      </h2>
      
      <div class="content-body">
        {!! $sejarah->body !!}
      </div>
    </div>
  @else
    <div class="alert alert-info alert-custom" data-aos="fade-up">
      <i class="ti ti-info-circle me-3"></i>
      <div>
        <h4 class="alert-heading">Belum ada konten sejarah</h4>
        <p class="mb-0">Konten sejarah desa belum tersedia. Silakan tambahkan konten sejarah untuk memberikan informasi tentang perjalanan desa.</p>
      </div>
    </div>
  @endif

  <!-- Daftar Kepala Desa per Periode -->
  <div class="timeline-section" data-aos="fade-up" data-aos-delay="100">
    <div class="timeline-header">
      <h2 class="timeline-title">
        <i class="ti ti-users me-3"></i>Daftar Kepala Desa
      </h2>
      <span class="timeline-subtitle">per periode jabatan</span>
    </div>
    
    @if($kepalaDesas->count() > 0)
      <div class="timeline">
        @foreach($kepalaDesas as $k)
          <div class="timeline-item" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 6) * 100 }}">
            <div class="timeline-card">
              <!-- Photo Container -->
              <div class="photo-container">
                <div class="photo-wrapper">
                  @if($k->foto)
                    <img src="{{ asset('storage/'.$k->foto) }}"
                         alt="Foto {{ $k->nama }}"
                         class="img-fluid">
                  @else
                    <i class="ti ti-user photo-icon"></i>
                  @endif
                </div>
              </div>
              
              <!-- Info Container -->
              <div class="info-container">
                <div class="info-header">
                  <h5 class="info-name">{{ $k->nama }}</h5>
                  <span class="periode-badge">
                    <i class="ti ti-calendar me-1"></i>{{ $k->periode_label }}
                  </span>
                </div>
                
                @if($k->catatan)
                  <p class="info-catatan">
                    <i class="ti ti-file-text me-2"></i>{{ $k->catatan }}
                  </p>
                @endif
                
                <!-- Status Badge -->
                <div class="mt-2">
                  @if($k->is_active)
                    <span class="badge bg-success">
                      <i class="ti ti-circle-check me-1"></i>Aktif
                    </span>
                  @else
                    <span class="badge bg-secondary">
                      <i class="ti ti-history me-1"></i>Periode Selesai
                    </span>
                  @endif
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @else
      <div class="empty-state" data-aos="fade-up">
        <i class="ti ti-users"></i>
        <h4>Belum ada data kepala desa</h4>
        <p>Data kepala desa dari berbagai periode belum tersedia.</p>
        <a href="{{ route('kepala-desa.create') }}" class="btn btn-primary">
          <i class="ti ti-plus me-2"></i>Tambah Data Pertama
        </a>
      </div>
    @endif
  </div>
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

  // Add hover effects to timeline cards
  const timelineCards = document.querySelectorAll('.timeline-card');
  timelineCards.forEach(card => {
    card.addEventListener('mouseenter', function() {
      this.style.transform = 'translateY(-5px)';
    });
    
    card.addEventListener('mouseleave', function() {
      this.style.transform = 'translateY(0)';
    });
  });

  // Add hover effects to timeline items
  const timelineItems = document.querySelectorAll('.timeline-item');
  timelineItems.forEach(item => {
    item.addEventListener('mouseenter', function() {
      const before = this.querySelector('::before');
      if (before) {
        before.style.transform = 'scale(1.2)';
      }
    });
    
    item.addEventListener('mouseleave', function() {
      const before = this.querySelector('::before');
      if (before) {
        before.style.transform = 'scale(1)';
      }
    });
  });
});
</script>
@endpush

@push('styles')
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet"/>
@endpush