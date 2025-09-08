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
  
  /* Breadcrumb */
  .breadcrumb-container {
    padding: 1.5rem 3rem;
    border-bottom: 1px solid #e9ecef;
  }
  
  .breadcrumb {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin: 0;
    padding: 0;
    list-style: none;
    background: transparent;
  }
  
  .breadcrumb-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }
  
  .breadcrumb-item a {
    color: #667eea;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.3s ease;
  }
  
  .breadcrumb-item a:hover {
    color: #764ba2;
  }
  
  .breadcrumb-item.active {
    color: #6c757d;
  }
  
  .breadcrumb-item+.breadcrumb-item::before {
    content: "›";
    color: #dee2e6;
    font-size: 1.2rem;
    margin-right: 0.5rem;
  }
  
  /* Article Header */
  .article-header {
    padding: 3rem;
    border-bottom: 1px solid #e9ecef;
  }
  
  .article-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 1.5rem;
    line-height: 1.2;
  }
  
  .article-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 1.5rem;
    align-items: center;
  }
  
  .meta-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #6c757d;
    font-size: 0.95rem;
  }
  
  .meta-item i {
    color: #667eea;
    font-size: 1.1rem;
  }
  
  .meta-item strong {
    color: #495057;
    font-weight: 600;
  }
  
  /* Article Content */
  .article-content {
    padding: 3rem;
  }
  
  .article-image {
    border-radius: 15px;
    overflow: hidden;
    margin-bottom: 2.5rem;
    box-shadow: 0 15px 30px rgba(0,0,0,0.1);
  }
  
  .article-image img {
    width: 100%;
    height: auto;
    transition: transform 0.5s ease;
  }
  
  .article-image:hover img {
    transform: scale(1.02);
  }
  
  .article-body {
    font-size: 1.1rem;
    line-height: 1.8;
    color: #495057;
  }
  
  .article-body p {
    margin-bottom: 1.5rem;
  }
  
  .article-body img {
    max-width: 100%;
    height: auto;
    border-radius: 10px;
    margin: 2rem 0;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
  }
  
  .article-body h1, .article-body h2, .article-body h3, 
  .article-body h4, .article-body h5, .article-body h6 {
    color: #2c3e50;
    margin-top: 2rem;
    margin-bottom: 1rem;
    font-weight: 600;
  }
  
  .article-body blockquote {
    border-left: 4px solid #667eea;
    padding-left: 1.5rem;
    margin: 2rem 0;
    font-style: italic;
    color: #6c757d;
  }
  
  /* Document Box */
  .document-box {
    background: #f8f9fa;
    border-radius: 15px;
    padding: 2rem;
    margin-top: 2.5rem;
    border: 1px solid #e9ecef;
    transition: all 0.3s ease;
  }
  
  .document-box:hover {
    box-shadow: 0 10px 25px rgba(0,0,0,0.05);
    transform: translateY(-3px);
  }
  
  .document-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
  }
  
  .document-title {
    font-size: 1.3rem;
    font-weight: 600;
    color: #2c3e50;
    display: flex;
    align-items: center;
    gap: 0.75rem;
  }
  
  .document-title i {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  
  .document-info {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    margin-bottom: 1.5rem;
  }
  
  .document-meta {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #6c757d;
    font-size: 0.9rem;
  }
  
  .document-meta i {
    color: #667eea;
  }
  
  .btn-download {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    border: none;
    border-radius: 50px;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.2);
  }
  
  .btn-download:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
    color: white;
  }
  
  /* Sidebar */
  .sidebar {
    position: sticky;
    top: 2rem;
  }
  
  .sidebar-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.05);
    overflow: hidden;
    margin-bottom: 2rem;
    transition: all 0.3s ease;
  }
  
  .sidebar-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
  }
  
  .sidebar-card .card-body {
    padding: 1.5rem;
  }
  
  .sidebar-title {
    font-size: 1.3rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 1.5rem;
    position: relative;
    padding-bottom: 0.75rem;
  }
  
  .sidebar-title::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 40px;
    height: 3px;
    background: linear-gradient(90deg, #667eea, #764ba2);
    border-radius: 2px;
  }
  
  .related-item {
    display: flex;
    gap: 1rem;
    margin-bottom: 1.5rem;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid #f1f3f5;
    transition: all 0.3s ease;
  }
  
  .related-item:last-child {
    border-bottom: none;
    margin-bottom: 0;
    padding-bottom: 0;
  }
  
  .related-item:hover {
    transform: translateX(5px);
  }
  
  .related-img {
    width: 80px;
    height: 80px;
    border-radius: 10px;
    overflow: hidden;
    flex-shrink: 0;
  }
  
  .related-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
  }
  
  .related-item:hover .related-img img {
    transform: scale(1.1);
  }
  
  .related-content {
    flex: 1;
  }
  
  .related-date {
    font-size: 0.85rem;
    color: #6c757d;
    margin-bottom: 0.25rem;
  }
  
  .related-title {
    font-size: 1rem;
    font-weight: 600;
    color: #2c3e50;
    line-height: 1.4;
    margin: 0;
  }
  
  .related-title a {
    color: inherit;
    text-decoration: none;
    transition: color 0.3s ease;
  }
  
  .related-title a:hover {
    color: #667eea;
  }
  
  /* Empty State */
  .empty-state {
    text-align: center;
    padding: 1.5rem;
    color: #6c757d;
  }
  
  .empty-state i {
    font-size: 2rem;
    color: #dee2e6;
    margin-bottom: 0.75rem;
  }
  
  /* Responsive */
  @media (max-width: 992px) {
    .sidebar {
      margin-top: 3rem;
      position: static;
    }
  }
  
  @media (max-width: 768px) {
    .article-title {
      font-size: 2rem;
    }
    
    .article-header, .article-content {
      padding: 2rem;
    }
    
    .document-box {
      padding: 1.5rem;
    }
    
    .related-item {
      flex-direction: column;
      gap: 0.75rem;
    }
    
    .related-img {
      width: 100%;
      height: 120px;
    }
  }
</style>

<!-- Hero Section -->
<div class="hero-section">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-8">
        <h1 class="display-4 fw-bold mb-4" data-aos="fade-right">
          <i class="ti ti-file-report me-3"></i>Detail APBDesa
        </h1>
        <p class="lead mb-0" data-aos="fade-right" data-aos-delay="100">
          Informasi lengkap dan detail tentang dokumen Anggaran Pendapatan dan Belanja Desa. 
          Akses informasi transparan tentang perencanaan dan pengelolaan keuangan desa.
        </p>
      </div>
      <div class="col-lg-4" data-aos="fade-left">
        <img src="{{ asset('images/apbdes-hero.svg') }}" alt="APBDes Hero" class="img-fluid">
      </div>
    </div>
  </div>
</div>

<!-- Main Content -->
<div class="container">
  <div class="row">
    <div class="col-lg-9">
      <div class="main-container" data-aos="fade-up">
        <!-- Breadcrumb -->
        <div class="breadcrumb-container">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="{{ route('home') }}">
                  <i class="ti ti-home me-1"></i> Beranda
                </a>
              </li>
              <li class="breadcrumb-item">
                <a href="/apbdesa">
                  <i class="ti ti-chart-pie me-1"></i> APBDesa
                </a>
              </li>
              <li class="breadcrumb-item active" aria-current="page">
                {{ $anggaran->judul }}
              </li>
            </ol>
          </nav>
        </div>
        
        <!-- Article Header -->
        <div class="article-header">
          <h1 class="article-title">{{ $anggaran->judul }}</h1>
          
          <div class="article-meta">
            <div class="meta-item">
              <i class="ti ti-calendar"></i>
              <span>Diterbitkan {{ $anggaran->created_at?->format('d F Y') ?? 'Tanggal tidak tersedia' }}</span>
            </div>
            
            <div class="meta-item">
              <i class="ti ti-clock"></i>
              <span>Diperbarui {{ $anggaran->updated_at?->format('d F Y') ?? 'Tanggal tidak tersedia' }}</span>
            </div>
          </div>
        </div>
        
        <!-- Article Content -->
        <div class="article-content">
          <!-- Article Image -->
          @if($anggaran->gambar)
            <div class="article-image">
              <img src="{{ asset('storage/' . $anggaran->gambar) }}" 
                   alt="Cover {{ $anggaran->judul }}"
                   onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($anggaran->judul) }}&background=random'">
            </div>
          @endif
          
          <!-- Article Body -->
          <div class="article-body">
            {!! $anggaran->keterangan !!}
          </div>
          
          <!-- Document Box -->
          @if($anggaran->dokumen_path)
            @php
              // Helper format size
              function human_filesize($bytes, $decimals = 1) {
                  $size = ['B','KB','MB','GB','TB'];
                  $factor = floor((strlen($bytes) - 1) / 3);
                  return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . ' ' . $size[$factor];
              }
            @endphp
            
            <div class="document-box" data-aos="fade-up" data-aos-delay="200">
              <div class="document-header">
                <div class="document-title">
                  <i class="ti ti-file-text"></i>
                  <span>Dokumen APBDes</span>
                </div>
              </div>
              
              <div class="document-info">
                <div class="document-meta">
                  <i class="ti ti-file-description"></i>
                  <span>{{ $anggaran->dokumen_original ?: basename($anggaran->dokumen_path) }}</span>
                </div>
                
                @if(!empty($anggaran->dokumen_size))
                  <div class="document-meta">
                    <i class="ti ti-database"></i>
                    <span>{{ human_filesize((int)$anggaran->dokumen_size) }}</span>
                  </div>
                @endif
              </div>
              
              <a href="{{ asset('storage/' . $anggaran->dokumen_path) }}" target="_blank" class="btn-download">
                <i class="ti ti-download"></i> Unduh Dokumen
              </a>
            </div>
          @endif
        </div>
      </div>
    </div>
    
    <!-- Sidebar -->
    <div class="col-lg-3">
      <div class="sidebar" data-aos="fade-left">
        <div class="sidebar-card">
          <div class="card-body">
            <h4 class="sidebar-title">
              <i class="ti ti-files me-2"></i> APBDes Lainnya
            </h4>
            
            @forelse($related as $r)
              <div class="related-item" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="related-img">
                  @if($r->gambar)
                    <img src="{{ asset('storage/' . $r->gambar) }}" alt="{{ $r->judul }}">
                  @else
                    <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-light">
                      <i class="ti ti-file-text text-muted"></i>
                    </div>
                  @endif
                </div>
                
                <div class="related-content">
                  <div class="related-date">
                    <i class="ti ti-calendar me-1"></i> {{ $r->created_at?->format('d M Y') }}
                  </div>
                  <h5 class="related-title">
                    <a href="{{ url('/apbdesa/' . $r->slug) }}">{{ $r->judul }}</a>
                  </h5>
                </div>
              </div>
            @empty
              <div class="empty-state">
                <i class="ti ti-file-off"></i>
                <p>Tidak ada data lain.</p>
              </div>
            @endforelse
          </div>
        </div>
      </div>
    </div>
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
});
</script>
@endpush

@push('styles')
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet"/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons@latest/iconfont/tabler-icons.min.css">
@endpush