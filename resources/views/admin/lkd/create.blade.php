@extends('admin.layouts.main')
@section('title','Tambah LKD')
@section('content')
<style>
  .card-custom {
    border: none;
    border-radius: 15px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
  }
  
  .card-custom:hover {
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
  }
  
  .form-label {
    font-weight: 600;
    color: #495057;
    margin-bottom: 0.5rem;
  }
  
  .form-control, .form-select {
    border-radius: 8px;
    border: 1px solid #ced4da;
    padding: 0.75rem 1rem;
    transition: all 0.3s ease;
  }
  
  .form-control:focus, .form-select:focus {
    border-color: #80bdff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
  }
  
  .btn-custom {
    border-radius: 8px;
    padding: 0.75rem 1.5rem;
    font-weight: 500;
    transition: all 0.3s ease;
  }
  
  .btn-custom:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
  }
  
  .preview-container {
    position: relative;
    overflow: hidden;
    border-radius: 12px;
    background: #f8f9fa;
    min-height: 250px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px dashed #dee2e6;
    transition: all 0.3s ease;
  }
  
  .preview-container:hover {
    border-color: #667eea;
    background: #f0f4ff;
  }
  
  .preview-container img {
    max-width: 100%;
    max-height: 250px;
    object-fit: cover;
    border-radius: 8px;
    transition: transform 0.3s ease;
  }
  
  .preview-container:hover img {
    transform: scale(1.02);
  }
  
  .slug-preview {
    font-family: 'Courier New', monospace;
    background: #f8f9fa;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    border: 1px solid #dee2e6;
    font-size: 0.9rem;
    color: #6c757d;
  }
  
  .input-group-text {
    background: #f8f9fa;
    border-color: #ced4da;
    color: #6c757d;
  }
  
  .section-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #495057;
    margin-bottom: 1.5rem;
    padding-bottom: 0.5rem;
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
</style>

<div class="card card-custom" data-aos="fade-up">
  <div class="card-header bg-primary text-white">
    <h5 class="mb-0"><i class="ti ti-plus me-2"></i>Tambah LKD Baru</h5>
  </div>
  <div class="card-body p-4">
    <form method="POST" action="{{ route('admin.lkd.store') }}" enctype="multipart/form-data" id="createForm">
      @csrf
      <div class="row g-4">
        <div class="col-md-8">
          <div class="mb-3">
            <label class="form-label">Judul <span class="text-danger">*</span></label>
            <input type="text" 
                   name="judul" 
                   class="form-control form-control-lg" 
                   value="{{ old('judul') }}" 
                   required 
                   id="judulInput"
                   placeholder="Masukkan judul LKD">
          </div>
          
          <div class="mb-3">
            <label class="form-label">Slug <span class="text-danger">*</span></label>
            <div class="input-group">
              <span class="input-group-text">{{ url('/lkd') }}/</span>
              <input type="text" 
                     name="slug" 
                     class="form-control" 
                     value="{{ old('slug') }}" 
                     required 
                     id="slugInput"
                     placeholder="slug-lkd">
            </div>
            <div class="form-text">Slug akan digunakan sebagai URL publik. Akan otomatis diisi dari judul jika kosong.</div>
          </div>
          
          <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="deskripsi" 
                      rows="6" 
                      class="form-control form-control-lg" 
                      placeholder="Masukkan deskripsi LKD...">{{ old('deskripsi') }}</textarea>
          </div>
          
          <div class="form-check form-switch form-switch-lg mb-3">
            <input class="form-check-input" 
                   type="checkbox" 
                   name="published" 
                   value="1" 
                   id="pub" 
                   {{ old('published') ? 'checked' : '' }}>
            <label class="form-check-label" for="pub">
              <i class="ti ti-world me-2"></i>Publikasikan sekarang
            </label>
          </div>
        </div>
        
        <div class="col-md-4">
          <div class="mb-3">
            <label class="form-label">Cover LKD</label>
            <div class="preview-container mb-3" id="coverPreviewContainer">
              <div class="text-center text-muted">
                <i class="ti ti-photo" style="font-size: 3rem;"></i>
                <p class="mt-2">Preview Cover</p>
                <small>Pilih gambar untuk melihat preview</small>
              </div>
            </div>
            <input type="file" 
                   name="cover" 
                   class="form-control" 
                   accept="image/*" 
                   id="coverInput">
            <div class="form-text mt-2">
              <i class="ti ti-info-circle me-1"></i>
              Format: JPG, PNG, atau WEBP. Maksimal 2MB.
            </div>
          </div>
          
          <div class="alert alert-info">
            <i class="ti ti-bulb me-2"></i>
            <strong>Tip:</strong> Cover yang menarik akan membuat LKD Anda lebih profesional.
          </div>
        </div>
      </div>
      
      <div class="row mt-4">
        <div class="col-12">
          <div class="d-flex gap-3">
            <button type="submit" class="btn btn-primary btn-custom btn-lg">
              <i class="ti ti-device-floppy me-2"></i>Simpan LKD
            </button>
            <a href="{{ route('admin.lkd.index') }}" class="btn btn-secondary btn-custom btn-lg">
              <i class="ti ti-arrow-left me-2"></i>Kembali
            </a>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Preview Slug -->
<div class="card card-custom mt-4" data-aos="fade-up" data-aos-delay="100">
  <div class="card-body">
    <h6 class="mb-3"><i class="ti ti-link me-2"></i>Preview URL</h6>
    <div class="slug-preview" id="slugPreview">
      {{ url('/lkd') }}/<span id="slugText">{{ old('slug') ?: 'slug-lkd' }}</span>
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

  // Slug generation
  const judulInput = document.getElementById('judulInput');
  const slugInput = document.getElementById('slugInput');
  const slugText = document.getElementById('slugText');
  let slugUserEdited = false;

  // Function to generate slug
  function slugify(text) {
    return text.toString().toLowerCase()
      .replace(/\s+/g, '-')           // Replace spaces with -
      .replace(/[^\w\-]+/g, '')      // Remove all non-word chars
      .replace(/\-\-+/g, '-')         // Replace multiple - with single -
      .replace(/^-+/, '')             // Trim - from start of text
      .replace(/-+$/, '');            // Trim - from end of text
  }

  // Auto-generate slug from judul
  if (judulInput && slugInput) {
    judulInput.addEventListener('input', function() {
      if (!slugUserEdited) {
        const slug = slugify(this.value);
        slugInput.value = slug;
        slugText.textContent = slug || 'slug-lkd';
      }
    });

    // Mark slug as user-edited when manually changed
    slugInput.addEventListener('input', function() {
      slugUserEdited = true;
      slugText.textContent = this.value || 'slug-lkd';
    });
  }

  // Cover preview
  const coverInput = document.getElementById('coverInput');
  const coverPreviewContainer = document.getElementById('coverPreviewContainer');

  if (coverInput && coverPreviewContainer) {
    coverInput.addEventListener('change', function(e) {
      const file = e.target.files[0];
      
      if (file) {
        // Validate file type
        if (!file.type.startsWith('image/')) {
          alert('File harus berupa gambar!');
          return;
        }
        
        // Validate file size (2MB)
        if (file.size > 2 * 1024 * 1024) {
          alert('Ukuran file maksimal 2MB!');
          return;
        }
        
        const reader = new FileReader();
        reader.onload = function(event) {
          coverPreviewContainer.innerHTML = `
            <img src="${event.target.result}" alt="Cover Preview">
          `;
        };
        reader.readAsDataURL(file);
      } else {
        // Reset to default state
        coverPreviewContainer.innerHTML = `
          <div class="text-center text-muted">
            <i class="ti ti-photo" style="font-size: 3rem;"></i>
            <p class="mt-2">Preview Cover</p>
            <small>Pilih gambar untuk melihat preview</small>
          </div>
        `;
      }
    });
  }

  // Form validation before submit
  const createForm = document.getElementById('createForm');
  if (createForm) {
    createForm.addEventListener('submit', function(e) {
      const judul = judulInput.value.trim();
      const slug = slugInput.value.trim();
      
      if (!judul) {
        e.preventDefault();
        alert('Judul harus diisi!');
        judulInput.focus();
        return;
      }
      
      if (!slug) {
        e.preventDefault();
        alert('Slug harus diisi!');
        slugInput.focus();
        return;
      }
      
      // Show loading state
      const submitBtn = this.querySelector('button[type="submit"]');
      submitBtn.disabled = true;
      submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';
    });
  }
});
</script>
@endpush

@push('styles')
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
@endpush