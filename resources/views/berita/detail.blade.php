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
    margin-bottom: 2rem;
    box-shadow: 0 15px 30px rgba(0,0,0,0.1);
  }
  
  .article-image img {
    width: 100%;
    height: 450px;
    object-fit: cover;
    transition: transform 0.5s ease;
  }
  
  .article-image:hover img {
    transform: scale(1.03);
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
  
  .article-tags {
    margin-top: 2rem;
    padding-top: 1.5rem;
    border-top: 1px solid #e9ecef;
  }
  
  .tag-badge {
    display: inline-block;
    padding: 0.5rem 1rem;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    border-radius: 50px;
    font-weight: 600;
    font-size: 0.9rem;
    transition: all 0.3s ease;
  }
  
  .tag-badge:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
    color: white;
  }
  
  /* Comments Section */
  .comments-section {
    padding: 3rem;
    border-top: 1px solid #e9ecef;
  }
  
  .section-title {
    font-size: 1.8rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 2rem;
    position: relative;
    padding-bottom: 1rem;
  }
  
  .section-title::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 60px;
    height: 3px;
    background: linear-gradient(90deg, #667eea, #764ba2);
    border-radius: 2px;
  }
  
  .comment-container {
    background: #f8f9fa;
    border-radius: 15px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    transition: all 0.3s ease;
  }
  
  .comment-container:hover {
    box-shadow: 0 10px 25px rgba(0,0,0,0.05);
    transform: translateY(-3px);
  }
  
  .comment-avatar {
    flex-shrink: 0;
  }
  
  .comment-avatar img {
    border-radius: 50%;
    border: 3px solid white;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
  }
  
  .comment-content {
    flex-grow: 1;
  }
  
  .comment-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.5rem;
  }
  
  .comment-header h5 {
    font-size: 1.1rem;
    font-weight: 600;
    color: #2c3e50;
    margin: 0;
  }
  
  .comment-header time {
    font-size: 0.85rem;
    color: #6c757d;
  }
  
  .comment-body {
    color: #495057;
    line-height: 1.6;
    margin: 0;
  }
  
  .reply-btn {
    color: #667eea;
    font-size: 0.9rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
  }
  
  .reply-btn:hover {
    color: #764ba2;
  }
  
  .comment-reply {
    margin-left: 3rem;
    margin-top: 1rem;
  }
  
  .reply-form {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    margin-top: 1rem;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
  }
  
  /* Comment Form */
  .comment-form-container {
    background: #f8f9fa;
    border-radius: 15px;
    padding: 2rem;
    margin-top: 2rem;
  }
  
  .form-label {
    font-weight: 600;
    color: #495057;
    margin-bottom: 0.5rem;
  }
  
  .form-control {
    border-radius: 10px;
    border: 1px solid #e9ecef;
    padding: 0.75rem 1rem;
    font-size: 1rem;
    transition: all 0.3s ease;
  }
  
  .form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.1);
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
  
  .popular-post {
    margin-bottom: 1.5rem;
  }
  
  .popular-post-item {
    display: flex;
    margin-bottom: 1.5rem;
    transition: all 0.3s ease;
  }
  
  .popular-post-item:hover {
    transform: translateX(5px);
  }
  
  .popular-post-img {
    width: 80px;
    height: 80px;
    border-radius: 10px;
    overflow: hidden;
    flex-shrink: 0;
  }
  
  .popular-post-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
  }
  
  .popular-post-item:hover .popular-post-img img {
    transform: scale(1.1);
  }
  
  .popular-post-content {
    padding-left: 1rem;
  }
  
  .popular-post-content h6 {
    font-size: 1rem;
    font-weight: 600;
    color: #2c3e50;
    margin: 0 0 0.5rem 0;
    line-height: 1.4;
  }
  
  .popular-post-content a {
    color: inherit;
    text-decoration: none;
    transition: color 0.3s ease;
  }
  
  .popular-post-content a:hover {
    color: #667eea;
  }
  
  .category-list {
    list-style: none;
    padding: 0;
    margin: 0;
  }
  
  .category-item {
    margin-bottom: 0.75rem;
    padding-bottom: 0.75rem;
    border-bottom: 1px solid #f1f3f5;
    transition: all 0.3s ease;
  }
  
  .category-item:last-child {
    border-bottom: none;
    margin-bottom: 0;
    padding-bottom: 0;
  }
  
  .category-item:hover {
    transform: translateX(5px);
  }
  
  .category-link {
    display: flex;
    align-items: center;
    color: #495057;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.3s ease;
  }
  
  .category-link:hover {
    color: #667eea;
  }
  
  .category-link i {
    color: #667eea;
    margin-right: 0.5rem;
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
    
    .article-header, .article-content, .comments-section {
      padding: 2rem;
    }
    
    .comment-reply {
      margin-left: 1.5rem;
    }
  }
</style>

<!-- Hero Section -->
<div class="hero-section">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-8">
        <h1 class="display-4 fw-bold mb-4" data-aos="fade-right">
          <i class="ti ti-article me-3"></i>Detail Berita
        </h1>
        <p class="lead mb-0" data-aos="fade-right" data-aos-delay="100">
          Informasi lengkap dan detail tentang berita terkini dari desa. 
          Tetap update dengan berbagai perkembangan dan prestasi desa kami.
        </p>
      </div>
      <div class="col-lg-4" data-aos="fade-left">
        <img src="{{ asset('images/article-hero.svg') }}" alt="Article Hero" class="img-fluid">
      </div>
    </div>
  </div>
</div>

<!-- Main Content -->
<div class="container">
  <div class="row">
    <div class="col-lg-8">
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
                <a href="/berita">
                  <i class="ti ti-news me-1"></i> Berita
                </a>
              </li>
              <li class="breadcrumb-item active" aria-current="page">
                {{ $berita->judul }}
              </li>
            </ol>
          </nav>
        </div>
        
        <!-- Article Header -->
        <div class="article-header">
          <h1 class="article-title">{{ $berita->judul }}</h1>
          
          <div class="article-meta">
            <div class="meta-item">
              <i class="ti ti-calendar"></i>
              <span>{{ $berita->created_at?->format('d F Y') ?? 'Tanggal tidak tersedia' }}</span>
            </div>
            
            <div class="meta-item">
              <i class="ti ti-clock"></i>
              <span>{{ $berita->created_at?->diffForHumans() ?? 'Baru saja' }}</span>
            </div>
            
            <div class="meta-item">
              <i class="ti ti-user"></i>
              <span>oleh <strong>{{ $berita->user->name ?? 'Administrator' }}</strong></span>
            </div>
            
            <div class="meta-item">
              <i class="ti ti-eye"></i>
              <span><strong>{{ $berita->views ?? 0 }}</strong> kali dibaca</span>
            </div>
          </div>
        </div>
        
        <!-- Article Content -->
        <div class="article-content">
          <div class="article-image">
            <img src="{{ $berita->gambar ? asset('storage/' . $berita->gambar) : 'https://ui-avatars.com/api/?name=' . urlencode($berita->judul) . '&background=random' }}" 
                 alt="{{ $berita->judul }}"
                 onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($berita->judul) }}&background=random'">
          </div>
          
          <div class="article-body">
            {!! $berita->body !!}
          </div>
          
          <div class="article-tags">
            <a href="/kategori/{{ $berita->kategori->slug ?? '#' }}" class="tag-badge">
              <i class="ti ti-hash me-1"></i> {{ $berita->kategori->kategori ?? 'Uncategorized' }}
            </a>
          </div>
        </div>
        
        <!-- Comments Section -->
        <div class="comments-section">
          <h3 class="section-title">Komentar</h3>
          
          @if($berita->comments->count() > 0)
            @foreach ($berita->comments as $comment)
              @php
                $emailHash = md5(strtolower(trim($comment->email)));
                $avatarUrl = "https://www.gravatar.com/avatar/{$emailHash}?s=65";
              @endphp
              
              <div class="comment-container" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="d-flex align-items-start">
                  <div class="comment-avatar me-3">
                    <img class="shadow-1-strong" src="{{ $avatarUrl }}" alt="Avatar" width="65" height="65">
                  </div>
                  <div class="comment-content flex-grow-1">
                    <div class="comment-header">
                      <h5>{{ $comment->nama }}</h5>
                      <time>{{ $comment->created_at?->diffForHumans() ?? 'Baru saja' }}</time>
                    </div>
                    <p class="comment-body">{{ $comment->body }}</p>
                    <div class="mt-2">
                      <a href="javascript:void(0)" onclick="toggleReplyForm({{ $comment->id }})" class="reply-btn">
                        <i class="ti ti-arrow-back-up"></i> Balas
                      </a>
                    </div>
                  </div>
                </div>
                
                <!-- Comment Reply -->
                @if($comment->replies->count() > 0)
                  @foreach ($comment->replies as $reply)
                    @php
                      $replyEmailHash = md5(strtolower(trim($reply->email)));
                      $replyAvatarUrl = "https://www.gravatar.com/avatar/{$replyEmailHash}?s=65";
                    @endphp
                    
                    <div class="comment-reply" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                      <div class="d-flex align-items-start">
                        <div class="comment-avatar me-3">
                          <img class="shadow-1-strong" src="{{ $replyAvatarUrl }}" alt="Avatar" width="55" height="55">
                        </div>
                        <div class="comment-content flex-grow-1">
                          <div class="comment-header">
                            <h5>{{ $reply->nama }}</h5>
                            <time>{{ $reply->created_at?->diffForHumans() ?? 'Baru saja' }}</time>
                          </div>
                          <p class="comment-body">{{ $reply->body }}</p>
                        </div>
                      </div>
                    </div>
                  @endforeach
                @endif
                
                <!-- Comment Reply Form -->
                <div id="replyForm{{ $comment->id }}" class="reply-form" style="display: none;">
                  <form action="/berita/{{ $berita->slug }}/reply" method="POST">
                    @csrf
                    <input type="hidden" value="{{ $comment->id }}" name="comment_id">
                    <div class="mb-3">
                      <input type="text" class="form-control" placeholder="Nama" name="replyNama">
                    </div>
                    <div class="mb-3">
                      <input type="email" class="form-control" placeholder="Email" name="replyEmail">
                    </div>
                    <div class="mb-3">
                      <textarea class="form-control" placeholder="Balasan Komentar" name="replyBody" rows="3"></textarea>
                    </div>
                    <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                    <button type="submit" class="btn btn-primary btn-sm">
                      <i class="ti ti-send me-1"></i> Kirim Balasan
                    </button>
                  </form>
                </div>
              </div>
            @endforeach
          @else
            <div class="text-center py-4">
              <i class="ti ti-message-circle-off display-4 text-muted"></i>
              <p class="mt-2 text-muted">Belum ada komentar</p>
            </div>
          @endif
          
          <!-- Comment Form -->
          <div class="comment-form-container" data-aos="fade-up">
            <h3 class="section-title">Tinggalkan Komentar</h3>
            <form method="POST" action="/berita/{{ $berita->slug }}">
              @csrf
              <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama">
                @error('nama')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email">
                @error('email')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
              <div class="mb-3">
                <label for="body" class="form-label">Komentar</label>
                <textarea class="form-control @error('body') is-invalid @enderror" id="body" name="body" rows="6"></textarea>
                @error('body')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
              <button type="submit" class="btn btn-primary">
                <i class="ti ti-send me-2"></i> Kirim Komentar
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Sidebar -->
    <div class="col-lg-4">
      <div class="sidebar" data-aos="fade-left">
        <!-- Popular News -->
        <div class="sidebar-card">
          <div class="card-body">
            <h4 class="sidebar-title">
              <i class="ti ti-trending-up me-2"></i> Berita Populer
            </h4>
            <div class="popular-post">
              @if(isset($beritaPopuler) && $beritaPopuler->count() > 0)
                @foreach ($beritaPopuler as $beritaPop)
                  <div class="popular-post-item" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="popular-post-img">
                      <img src="{{ $beritaPop->gambar ? asset('storage/' . $beritaPop->gambar) : 'https://ui-avatars.com/api/?name=' . urlencode($beritaPop->judul) . '&background=random' }}" 
                           alt="{{ $beritaPop->judul }}"
                           onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($beritaPop->judul) }}&background=random'">
                    </div>
                    <div class="popular-post-content">
                      <a href="/berita/{{ $beritaPop->slug }}">
                        <h6>{{ $beritaPop->judul }}</h6>
                      </a>
                      <small class="text-muted">
                        <i class="ti ti-eye me-1"></i> {{ $beritaPop->views ?? 0 }} kali dibaca
                      </small>
                    </div>
                  </div>
                @endforeach
              @else
                <p class="text-muted">Belum ada berita populer</p>
              @endif
            </div>
          </div>
        </div>
        
        <!-- Categories -->
        <div class="sidebar-card">
          <div class="card-body">
            <h4 class="sidebar-title">
              <i class="ti ti-category me-2"></i> Kategori
            </h4>
            <div class="category-list">
              @if(isset($kategories) && $kategories->count() > 0)
                @foreach ($kategories as $kategori)
                  <div class="category-item" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <a href="/kategori/{{ $kategori->slug }}" class="category-link">
                      <i class="ti ti-hash"></i> {{ $kategori->kategori }}
                    </a>
                  </div>
                @endforeach
              @else
                <p class="text-muted">Belum ada kategori</p>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  function toggleReplyForm(commentId) {
    var replyForm = document.getElementById('replyForm' + commentId);
    var formDisplayStyle = window.getComputedStyle(replyForm).getPropertyValue('display');
    if (formDisplayStyle === 'none') {
      replyForm.style.display = 'block';
    } else {
      replyForm.style.display = 'none';
    }
  }
</script>
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