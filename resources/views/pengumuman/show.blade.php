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
  
  /* Article Footer */
  .article-footer {
    padding: 2rem 3rem;
    background: #f8f9fa;
    border-top: 1px solid #e9ecef;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
  }
  
  .back-button {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: white;
    background: linear-gradient(135deg, #667eea, #764ba2);
    padding: 0.75rem 1.5rem;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.2);
  }
  
  .back-button:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
    color: white;
  }
  
  .share-buttons {
    display: flex;
    gap: 0.75rem;
  }
  
  .share-button {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    text-decoration: none;
    transition: all 0.3s ease;
  }
  
  .share-facebook {
    background: #3b5998;
  }
  
  .share-twitter {
    background: #1da1f2;
  }
  
  .share-whatsapp {
    background: #25d366;
  }
  
  .share-button:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
  }
  
  /* Responsive */
  @media (max-width: 768px) {
    .article-title {
      font-size: 2rem;
    }
    
    .article-header, .article-content {
      padding: 2rem;
    }
    
    .article-footer {
      padding: 1.5rem 2rem;
      flex-direction: column;
      align-items: stretch;
    }
    
    .share-buttons {
      justify-content: center;
    }
  }
</style>

<!-- Hero Section -->
<div class="hero-section">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-8">
        <h1 class="display-4 fw-bold mb-4" data-aos="fade-right">
          <i class="ti ti-article me-3"></i>Detail Pengumuman
        </h1>
        <p class="lead mb-0" data-aos="fade-right" data-aos-delay="100">
          Informasi lengkap dan detail tentang pengumuman terkini dari desa. 
          Tetap update dengan berita penting yang disampaikan oleh pemerintah desa.
        </p>
      </div>
      <div class="col-lg-4" data-aos="fade-left">
        <img src="{{ asset('images/article-hero.svg') }}" alt="Article Hero" class="img-fluid">
      </div>
    </div>
  </div>
</div>

<!-- Main Content -->
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
          <a href="/pengumuman">
            <i class="ti ti-bell me-1"></i> Pengumuman
          </a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
          {{ $pengumuman->judul }}
        </li>
      </ol>
    </nav>
  </div>
  
  <!-- Article Header -->
  <div class="article-header">
    <h1 class="article-title">{{ $pengumuman->judul }}</h1>
    
    <div class="article-meta">
      <div class="meta-item">
        <i class="ti ti-calendar"></i>
        <span>{{ $pengumuman->created_at?->format('d F Y') ?? 'Tanggal tidak tersedia' }}</span>
      </div>
      
      <div class="meta-item">
        <i class="ti ti-clock"></i>
        <span>{{ $pengumuman->created_at?->diffForHumans() ?? 'Baru saja' }}</span>
      </div>
      
      <div class="meta-item">
        <i class="ti ti-user"></i>
        <span>oleh <strong>{{ $pengumuman->user->name ?? 'Administrator' }}</strong></span>
      </div>
      
      <div class="meta-item">
        <i class="ti ti-eye"></i>
        <span><strong>{{ $pengumuman->views ?? 0 }}</strong> kali dibaca</span>
      </div>
    </div>
  </div>
  
  <!-- Article Content -->
  <div class="article-content">
    <div class="article-body">
      {!! $pengumuman->isi_pengumuman !!}
    </div>
  </div>
  
  <!-- Article Footer -->
  <div class="article-footer">
    <a href="/pengumuman" class="back-button">
      <i class="ti ti-arrow-left"></i> Kembali ke Pengumuman
    </a>
    
    <div class="share-buttons">
      <a href="https://www.facebook.com/sharer/sharer.php?u={{ request()->url() }}" target="_blank" class="share-button share-facebook" title="Bagikan ke Facebook">
        <i class="ti ti-brand-facebook"></i>
      </a>
      <a href="https://twitter.com/intent/tweet?url={{ request()->url() }}&text={{ $pengumuman->judul }}" target="_blank" class="share-button share-twitter" title="Bagikan ke Twitter">
        <i class="ti ti-brand-twitter"></i>
      </a>
      <a href="https://wa.me/?text={{ $pengumuman->judul }}%20{{ request()->url() }}" target="_blank" class="share-button share-whatsapp" title="Bagikan ke WhatsApp">
        <i class="ti ti-brand-whatsapp"></i>
      </a>
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