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
  
  /* Gallery Container */
  .gallery-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 2rem;
    padding: 0 3rem 3rem;
  }
  
  /* Gallery Item */
  .gallery-item {
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
  
  .gallery-item::before {
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
  
  .gallery-item:hover::before {
    transform: scaleX(1);
  }
  
  .gallery-item:hover {
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
  
  .gallery-item:hover .img-container img {
    transform: scale(1.05);
  }
  
  /* Image Overlay */
  .img-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to bottom, transparent 0%, rgba(0,0,0,0.7) 100%);
    opacity: 0;
    transition: opacity 0.3s ease;
    display: flex;
    align-items: flex-end;
    padding: 1rem;
  }
  
  .gallery-item:hover .img-overlay {
    opacity: 1;
  }
  
  .view-icon {
    width: 40px;
    height: 40px;
    background: rgba(255,255,255,0.9);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #667eea;
    font-size: 1.2rem;
    margin-left: auto;
    transition: all 0.3s ease;
  }
  
  .view-icon:hover {
    background: white;
    transform: scale(1.1);
  }
  
  /* Gallery Content */
  .gallery-content {
    padding: 1.5rem;
    flex: 1;
    display: flex;
    flex-direction: column;
  }
  
  .gallery-title {
    font-size: 1.2rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.5rem;
    line-height: 1.4;
  }
  
  .gallery-meta {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #6c757d;
    font-size: 0.9rem;
    margin-top: auto;
  }
  
  .gallery-meta i {
    color: #667eea;
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
  
  /* Lightbox Modal */
  .lightbox-modal {
    display: none;
    position: fixed;
    z-index: 9999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.9);
    animation: fadeIn 0.3s ease;
  }
  
  @keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
  }
  
  .lightbox-content {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    max-width: 90%;
    max-height: 90%;
  }
  
  .lightbox-content img {
    width: 100%;
    height: auto;
    border-radius: 10px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.5);
  }
  
  .lightbox-caption {
    position: absolute;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    color: white;
    background: rgba(0,0,0,0.7);
    padding: 1rem 2rem;
    border-radius: 50px;
    font-size: 1.1rem;
    max-width: 80%;
    text-align: center;
  }
  
  .lightbox-close {
    position: absolute;
    top: 20px;
    right: 40px;
    color: white;
    font-size: 40px;
    font-weight: bold;
    cursor: pointer;
    transition: all 0.3s ease;
  }
  
  .lightbox-close:hover {
    color: #667eea;
    transform: rotate(90deg);
  }
  
  /* Responsive */
  @media (max-width: 768px) {
    .gallery-container {
      grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
      gap: 1.5rem;
      padding: 0 2rem 2rem;
    }
    
    .section-title h2 {
      font-size: 2rem;
    }
    
    .pagination-container {
      padding: 0 2rem 2rem;
    }
    
    .lightbox-caption {
      font-size: 0.9rem;
      padding: 0.75rem 1.5rem;
    }
  }
</style>

<!-- Hero Section -->
<div class="hero-section">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-8">
        <h1 class="display-4 fw-bold mb-4" data-aos="fade-right">
          <i class="ti ti-photo me-3"></i>Gallery Desa
        </h1>
        <p class="lead mb-0" data-aos="fade-right" data-aos-delay="100">
          Kumpulan foto dan dokumentasi kegiatan desa. Melihat berbagai momen berharga 
          dan perkembangan desa melalui galeri foto yang kami sajikan.
        </p>
      </div>
      <div class="col-lg-4" data-aos="fade-left">
        <img src="{{ asset('images/gallery-hero.svg') }}" alt="Gallery Hero" class="img-fluid">
      </div>
    </div>
  </div>
</div>

<!-- Main Content -->
<div class="main-container" data-aos="fade-up">
  <div class="section-title">
    <h2><i class="ti ti-images me-3"></i>Gallery Foto</h2>
    <p class="section-subtitle">Dokumentasi Kegiatan Desa</p>
  </div>
  
  @if($galerrys->count() > 0)
    <div class="gallery-container">
      @foreach ($galerrys as $gallery)
        <div class="gallery-item" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
          <div class="img-container">
            <img src="{{ $gallery->gambar ? asset('storage/' . $gallery->gambar) : 'https://ui-avatars.com/api/?name=' . urlencode($gallery->keterangan ?? 'Gallery') . '&background=random' }}" 
                 alt="{{ $gallery->keterangan ?? 'Gallery' }}"
                 onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($gallery->keterangan ?? 'Gallery') }}&background=random'"
                 onclick="openLightbox(this)">
            
            <div class="img-overlay">
              <div class="view-icon" onclick="openLightbox(this.parentElement.parentElement.querySelector('img'))">
                <i class="ti ti-maximize"></i>
              </div>
            </div>
          </div>
          
          <div class="gallery-content">
            <h3 class="gallery-title">{{ $gallery->keterangan ?? 'Tanpa Keterangan' }}</h3>
            
            <div class="gallery-meta">
              <i class="ti ti-calendar me-1"></i>
              <span>{{ $gallery->created_at?->format('d F Y') ?? 'Tanggal tidak tersedia' }}</span>
            </div>
          </div>
        </div>
      @endforeach
    </div>
    
    <div class="pagination-container">
      {{ $galerrys->links() }}
    </div>
  @else
    <div class="empty-state" data-aos="fade-up">
      <i class="ti ti-photo-off"></i>
      <h4>Belum ada Gallery</h4>
      <p>Belum ada foto galeri yang dipublikasikan. Silakan periksa kembali beberapa saat lagi.</p>
      <a href="{{ route('home') }}" class="btn btn-primary">
        <i class="ti ti-home me-2"></i>Kembali ke Beranda
      </a>
    </div>
  @endif
</div>

<!-- Lightbox Modal -->
<div id="lightboxModal" class="lightbox-modal">
  <span class="lightbox-close" onclick="closeLightbox()">&times;</span>
  <div class="lightbox-content">
    <img id="lightboxImg" src="" alt="">
    <div class="lightbox-caption" id="lightboxCaption"></div>
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
  
  // Add hover effects to cards
  const cards = document.querySelectorAll('.gallery-item');
  cards.forEach(card => {
    card.addEventListener('mouseenter', function() {
      this.style.transform = 'translateY(-10px)';
    });
    
    card.addEventListener('mouseleave', function() {
      this.style.transform = 'translateY(0)';
    });
  });
});

// Lightbox functionality
function openLightbox(img) {
  const modal = document.getElementById('lightboxModal');
  const modalImg = document.getElementById('lightboxImg');
  const captionText = document.getElementById('lightboxCaption');
  
  modal.style.display = 'block';
  modalImg.src = img.src;
  
  // Get caption from parent gallery item
  const galleryItem = img.closest('.gallery-item');
  const galleryTitle = galleryItem.querySelector('.gallery-title');
  captionText.textContent = galleryTitle ? galleryTitle.textContent : '';
  
  // Prevent event bubbling
  event.stopPropagation();
}

function closeLightbox() {
  document.getElementById('lightboxModal').style.display = 'none';
}

// Close lightbox when clicking outside the image
window.onclick = function(event) {
  const modal = document.getElementById('lightboxModal');
  if (event.target == modal) {
    modal.style.display = 'none';
  }
}

// Close lightbox with Escape key
document.addEventListener('keydown', function(event) {
  if (event.key === 'Escape') {
    closeLightbox();
  }
});
</script>
@endpush

@push('styles')
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet"/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons@latest/iconfont/tabler-icons.min.css">
@endpush