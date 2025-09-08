@extends('layouts.main')
@section('title',$lkd->judul)
@section('content')
@php
  // Helper function untuk menampilkan foto (sesuai pola sebelumnya)
  function getPhotoUrl($path, $placeholder = 'https://via.placeholder.com/400x300?text=Foto') {
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
  
  /* Cover Container */
  .cover-container {
    position: relative;
    overflow: hidden;
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
    margin-bottom: 3rem;
    background: #f8f9fa;
    min-height: 400px;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  
  .cover-container img {
    width: 100%;
    height: 400px;
    object-fit: cover;
    transition: transform 0.5s ease;
  }
  
  .cover-container:hover img {
    transform: scale(1.02);
  }
  
  /* Info Section */
  .info-section {
    background: white;
    border-radius: 20px;
    padding: 3rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    margin-bottom: 3rem;
    position: relative;
  }
  
  .info-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 5px;
    background: linear-gradient(90deg, #667eea, #764ba2);
    border-radius: 20px 20px 0 0;
  }
  
  .info-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 1rem;
    position: relative;
    display: inline-block;
  }
  
  .info-title::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 0;
    width: 60px;
    height: 4px;
    background: linear-gradient(45deg, #667eea, #764ba2);
    border-radius: 2px;
  }
  
  .info-description {
    font-size: 1.1rem;
    color: #6c757d;
    line-height: 1.8;
    margin-bottom: 2rem;
  }
  
  /* Meta Info */
  .meta-info {
    display: flex;
    flex-wrap: wrap;
    gap: 2rem;
    margin-bottom: 2rem;
  }
  
  .meta-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #6c757d;
  }
  
  .meta-item i {
    font-size: 1.2rem;
    color: #667eea;
  }
  
  /* Members Section */
  .members-section {
    margin-bottom: 3rem;
  }
  
  .section-title {
    font-size: 2rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #e9ecef;
    position: relative;
  }
  
  .section-title::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 60px;
    height: 2px;
    background: linear-gradient(45deg, #667eea, #764ba2);
  }
  
  /* Member Cards */
  .member-card {
    background: white;
    border: none;
    border-radius: 20px;
    padding: 2rem;
    text-align: center;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
  }
  
  .member-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
  }
  
  .member-photo {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #e9ecef;
    transition: all 0.3s ease;
    margin-bottom: 1.5rem;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
  }
  
  .member-card:hover .member-photo {
    transform: scale(1.1);
    border-color: #667eea;
  }
  
  .member-name {
    font-size: 1.2rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 0.5rem;
  }
  
  .member-position {
    color: #6c757d;
    font-size: 0.95rem;
    margin-bottom: 1rem;
  }
  
  .member-badge {
    background: linear-gradient(45deg, #667eea, #764ba2);
    color: white;
    padding: 0.4rem 1rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    display: inline-block;
    transition: all 0.3s ease;
  }
  
  .member-badge:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
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
  
  /* Back Button */
  .back-button {
    position: fixed;
    bottom: 2rem;
    left: 2rem;
    background: linear-gradient(45deg, #667eea, #764ba2);
    color: white;
    border: none;
    border-radius: 50%;
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    transition: all 0.3s ease;
    z-index: 1000;
  }
  
  .back-button:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 40px rgba(102, 126, 234, 0.4);
  }
</style>

<!-- Cover Hero Section -->
<div class="cover-container" data-aos="fade-up">
  @if($lkd->cover_path)
    <div class="cover-wrapper">
      <img src="{{ getPhotoUrl($lkd->cover_path, 'https://via.placeholder.com/800x400?text=Cover+' . urlencode($lkd->judul)) }}" 
           alt="{{ $lkd->judul }}"
           class="cover-image">
    </div>
  @else
    <div class="text-center">
      <i class="ti ti-photo-off" style="font-size: 5rem; color: #dee2e6;"></i>
      <h3 class="mt-3">{{ $lkd->judul }}</h3>
    </div>
  @endif
</div>

<!-- Main Info Section -->
<div class="container">
  <div class="info-section" data-aos="fade-up" data-aos-delay="100">
    <h1 class="info-title">{{ $lkd->judul }}</h1>
    
    <!-- Meta Information -->
    <div class="meta-info" data-aos="fade-up" data-aos-delay="200">
      <div class="meta-item">
        <i class="ti ti-users"></i>
        <span>{{ $lkd->members()->count() }} Anggota</span>
      </div>
      <div class="meta-item">
        <i class="ti ti-calendar"></i>
        <span>{{ optional($lkd->updated_at)->format('d F Y') }}</span>
      </div>
      <div class="meta-item">
        <i class="ti ti-circle-check"></i>
        <span>{{ $lkd->published ? 'Dipublikasikan' : 'Draft' }}</span>
      </div>
    </div>
    
    <!-- Description -->
    <div class="info-description" data-aos="fade-up" data-aos-delay="300">
      {!! nl2br($lkd->deskripsi) !!}
    </div>
  </div>
  
  <!-- Members Section -->
  <div class="members-section" data-aos="fade-up" data-aos-delay="400">
    <h2 class="section-title">
      <i class="ti ti-users me-3"></i>Struktur / Anggota
    </h2>
    
    @if($lkd->members()->count() > 0)
      <div class="row g-4">
        @foreach($lkd->members()->orderBy('order_no')->orderBy('nama')->get() as $m)
          <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
            <div class="member-card">
              <!-- Member Photo -->
              @if($m->foto_path)
                <img src="{{ getPhotoUrl($m->foto_path, 'https://via.placeholder.com/120x120?text=Foto') }}" 
                     class="member-photo" 
                     alt="{{ $m->nama }}">
              @else
                <div class="member-photo bg-light d-flex align-items-center justify-content-center">
                  <i class="ti ti-user" style="font-size: 3rem; color: #dee2e6;"></i>
                </div>
              @endif
              
              <!-- Member Info -->
              <h5 class="member-name">{{ $m->nama }}</h5>
              <p class="member-position">{{ $m->jabatan }}</p>
              
              <!-- Member Badge -->
              @if($m->kategori)
                <span class="member-badge">
                  <i class="ti ti-tag me-1"></i>{{ strtoupper($m->kategori) }}
                </span>
              @endif
              
              <!-- Contact Info -->
              @if($m->kontak)
                <div class="mt-3">
                  <small class="text-muted">
                    <i class="ti ti-phone me-1"></i>{{ $m->kontak }}
                  </small>
                </div>
              @endif
              
              <!-- Active Status -->
              <div class="mt-2">
                @if($m->is_active)
                  <span class="badge bg-success">
                    <i class="ti ti-circle-check me-1"></i>Aktif
                  </span>
                @else
                  <span class="badge bg-secondary">
                    <i class="ti ti-circle-x me-1"></i>Tidak Aktif
                  </span>
                @endif
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @else
      <div class="empty-state" data-aos="fade-up">
        <i class="ti ti-users"></i>
        <h4>Belum ada anggota yang terdaftar</h4>
        <p class="text-muted">Struktur organisasi untuk {{ $lkd->judul }} belum tersedia.</p>
      </div>
    @endif
  </div>
</div>

<!-- Back Button -->
<a href="{{ route('lkd.index') }}" class="back-button" data-aos="fade-up" data-aos-delay="500">
  <i class="ti ti-arrow-left" style="font-size: 1.5rem;"></i>
</a>
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

  // Add hover effect to member cards
  const memberCards = document.querySelectorAll('.member-card');
  memberCards.forEach(card => {
    card.addEventListener('mouseenter', function() {
      this.style.transform = 'translateY(-10px)';
    });
    
    card.addEventListener('mouseleave', function() {
      this.style.transform = 'translateY(0)';
    });
  });

  // Smooth scroll for anchor links
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      e.preventDefault();
      const target = document.querySelector(this.getAttribute('href'));
      if (target) {
        target.scrollIntoView({
          behavior: 'smooth'
        });
      }
    });
  });
});
</script>
@endpush

@push('styles')
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
@endpush