@extends('admin.layouts.main')
@section('title','Edit LKD')
@section('content')
<!-- Flash Messages -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="ti ti-check me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="ti ti-alert-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@php
    // Helper function untuk menampilkan foto
    function getPhotoUrl($path, $placeholder = 'https://via.placeholder.com/400x400?text=Foto') {
        return $path ? asset('storage/' . $path) : $placeholder;
    }
@endphp

<style>
  .cover-preview {
    width: 100%;
    height: 250px;
    object-fit: cover;
    border-radius: 12px;
    border: 1px solid #e9ecef;
    transition: all 0.3s ease;
  }
  
  .member-photo {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #e9ecef;
    transition: all 0.3s ease;
  }
  
  .member-photo:hover {
    transform: scale(1.1);
    border-color: #667eea;
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
  }
  
  .preview-container img {
    transition: transform 0.3s ease;
  }
  
  .preview-container:hover img {
    transform: scale(1.05);
  }
  
  .ratio-container {
    position: relative;
    width: 100%;
    padding-bottom: 100%; /* Aspect Ratio 1:1 */
  }
  
  .ratio-container img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
</style>

<!-- Form Edit LKD -->
<div class="card shadow-lg mb-4">
  <div class="card-header bg-primary text-white">
    <h5 class="mb-0"><i class="ti ti-edit me-2"></i>Edit Informasi LKD</h5>
  </div>
  <div class="card-body">
    <form method="POST" action="{{ route('admin.lkd.update', $lkd) }}" enctype="multipart/form-data" id="lkdForm">
      @csrf @method('PUT')
      <div class="row g-4">
        <div class="col-md-8">
          <div class="mb-3">
            <label class="form-label">Judul <span class="text-danger">*</span></label>
            <input type="text" name="judul" class="form-control form-control-lg" value="{{ old('judul',$lkd->judul) }}" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="deskripsi" rows="6" class="form-control form-control-lg">{{ old('deskripsi',$lkd->deskripsi) }}</textarea>
          </div>
          <div class="form-check form-switch form-switch-lg mb-3">
            <input class="form-check-input" type="checkbox" name="published" value="1" id="pub" {{ $lkd->published ? 'checked' : '' }}>
            <label class="form-check-label" for="pub">Publikasikan</label>
          </div>
          <button type="submit" class="btn btn-primary btn-lg">
            <i class="ti ti-device-floppy me-2"></i>Update LKD
          </button>
        </div>
        <div class="col-md-4">
          <div class="mb-3">
            <label class="form-label">Cover Saat Ini</label>
            <div class="ratio-container mb-2">
              <img src="{{ getPhotoUrl($lkd->cover_path, 'https://via.placeholder.com/400x400?text=Cover+LKD') }}"
                   alt="{{ $lkd->judul }}"
                   id="currentCover">
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Ganti Cover</label>
            <input type="file" name="cover" class="form-control" accept="image/*" id="coverInput">
            <div class="form-text">JPG, PNG, atau WEBP. Maksimal 2MB.</div>
          </div>
          <div class="mt-3">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="removeCover" name="remove_cover" value="1">
              <label class="form-check-label" for="removeCover">
                Hapus cover saat ini
              </label>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Form Tambah Anggota -->
<div class="card shadow-lg mb-4">
  <div class="card-header bg-success text-white">
    <h5 class="mb-0"><i class="ti ti-user-plus me-2"></i>Tambah Anggota Baru</h5>
  </div>
  <div class="card-body">
    <form method="POST" action="{{ route('admin.lkd.members.store',$lkd) }}" enctype="multipart/form-data" id="memberForm">
      @csrf
      <div class="row g-3">
        <div class="col-md-4">
          <label class="form-label">Nama <span class="text-danger">*</span></label>
          <input type="text" name="nama" class="form-control" required>
        </div>
        <div class="col-md-4">
          <label class="form-label">Jabatan</label>
          <input type="text" name="jabatan" class="form-control">
        </div>
        <div class="col-md-4">
          <label class="form-label">Kategori</label>
          <select name="kategori" class="form-select">
            <option value="">-- Pilih Kategori --</option>
            <option value="struktur">Struktur</option>
            <option value="rt">RT</option>
            <option value="rw">RW</option>
            <option value="pkk">PKK</option>
            <option value="karang_taruna">Karang Taruna</option>
            <option value="lainnya">Lainnya</option>
          </select>
        </div>
        <div class="col-md-3">
          <label class="form-label">Urutan</label>
          <input type="number" name="order_no" class="form-control" min="0" value="0">
        </div>
        <div class="col-md-3">
          <label class="form-label">Foto</label>
          <input type="file" name="foto" class="form-control" accept="image/*">
        </div>
        <div class="col-md-3">
          <label class="form-label">Kontak</label>
          <input type="text" name="kontak" class="form-control" placeholder="No HP/Email">
        </div>
        <div class="col-md-3 d-flex align-items-end">
          <div class="form-check form-switch mt-3">
            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="active" checked>
            <label class="form-check-label" for="active">Aktif</label>
          </div>
        </div>
        <div class="col-12 mt-3">
          <button type="submit" class="btn btn-success">
            <i class="ti ti-user-plus me-2"></i>Tambah Anggota
          </button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Tabel Anggota -->
<div class="card shadow-lg">
  <div class="card-header bg-info text-white">
    <h5 class="mb-0"><i class="ti ti-users me-2"></i>Daftar Anggota LKD</h5>
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover mb-0">
        <thead class="table-dark">
          <tr>
            <th style="width:80px">Foto</th>
            <th>Nama</th>
            <th>Jabatan</th>
            <th>Kategori</th>
            <th>Urutan</th>
            <th>Kontak</th>
            <th>Status</th>
            <th style="width:180px">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($lkd->members as $m)
          <tr>
            <td>
              <div class="ratio ratio-1x1" style="width: 60px; height: 60px;">
                <img src="{{ getPhotoUrl($m->foto_path, 'https://via.placeholder.com/60x60?text=Foto') }}"
                     class="rounded-circle"
                     alt="{{ $m->nama }}">
              </div>
            </td>
            <td>
              <div class="fw-semibold">{{ $m->nama }}</div>
            </td>
            <td>{{ $m->jabatan }}</td>
            <td>
              <span class="badge bg-light text-dark">{{ $m->kategori }}</span>
            </td>
            <td>
              <span class="badge bg-primary">{{ $m->order_no }}</span>
            </td>
            <td>{{ $m->kontak ?: '-' }}</td>
            <td>
              <span class="badge {{ $m->is_active ? 'bg-success' : 'bg-danger' }}">
                {{ $m->is_active ? 'Aktif' : 'Tidak Aktif' }}
              </span>
            </td>
            <td>
              <div class="btn-group btn-group-sm" role="group">
                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $m->id }}">
                  <i class="ti ti-edit"></i>
                </button>
                <button type="button" class="btn btn-danger swal-confirm-delete" data-id="{{ $m->id }}" data-name="{{ $m->nama }}">
                  <i class="ti ti-trash"></i>
                </button>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="8" class="text-center py-4 text-muted">
              <i class="ti ti-users me-2" style="font-size: 1.5rem;"></i>
              <div>Belum ada anggota</div>
              <small class="text-muted">Tambahkan anggota menggunakan form di atas</small>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal Edit untuk setiap anggota -->
@forelse($lkd->members as $m)
<div class="modal fade" id="editModal{{ $m->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $m->id }}" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-warning">
        <h5 class="modal-title" id="editModalLabel{{ $m->id }}">Edit Anggota: {{ $m->nama }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{ route('admin.lkd.members.update', [$lkd,$m]) }}" enctype="multipart/form-data" id="editForm{{ $m->id }}">
          @csrf @method('PUT')
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Nama</label>
              <input type="text" name="nama" class="form-control" value="{{ $m->nama }}" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Jabatan</label>
              <input type="text" name="jabatan" class="form-control" value="{{ $m->jabatan }}">
            </div>
            <div class="col-md-6">
              <label class="form-label">Kategori</label>
              <select name="kategori" class="form-select">
                <option value="">-- Pilih Kategori --</option>
                <option value="struktur" {{ $m->kategori == 'struktur' ? 'selected' : '' }}>Struktur</option>
                <option value="rt" {{ $m->kategori == 'rt' ? 'selected' : '' }}>RT</option>
                <option value="rw" {{ $m->kategori == 'rw' ? 'selected' : '' }}>RW</option>
                <option value="pkk" {{ $m->kategori == 'pkk' ? 'selected' : '' }}>PKK</option>
                <option value="karang_taruna" {{ $m->kategori == 'karang_taruna' ? 'selected' : '' }}>Karang Taruna</option>
                <option value="lainnya" {{ $m->kategori == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Urutan</label>
              <input type="number" name="order_no" class="form-control" min="0" value="{{ $m->order_no }}">
            </div>
            <div class="col-md-6">
              <label class="form-label">Kontak</label>
              <input type="text" name="kontak" class="form-control" value="{{ $m->kontak }}" placeholder="No HP/Email">
            </div>
            <div class="col-md-6">
              <label class="form-label">Foto</label>
              <input type="file" name="foto" class="form-control" accept="image/*">
              <div class="form-text">Kosongkan jika tidak ingin mengubah foto</div>
              <!-- Preview foto saat ini -->
              <div class="mt-2">
                <div class="ratio ratio-1x1" style="width: 100px; height: 100px;">
                  <img src="{{ getPhotoUrl($m->foto_path, 'https://via.placeholder.com/100x100?text=Foto') }}"
                       class="img-thumbnail rounded"
                       alt="Foto saat ini">
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" name="is_active" value="1" id="active{{ $m->id }}" {{ $m->is_active ? 'checked' : '' }}>
                <label class="form-check-label" for="active{{ $m->id }}">Aktif</label>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-warning" onclick="document.getElementById('editForm{{ $m->id }}').submit()">
          <i class="ti ti-device-floppy me-2"></i>Simpan Perubahan
        </button>
      </div>
    </div>
  </div>
</div>
@empty
@endforelse
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Preview cover saat memilih file baru
  const coverInput = document.getElementById('coverInput');
  const currentCover = document.getElementById('currentCover');
  
  if (coverInput && currentCover) {
    coverInput.addEventListener('change', function(e) {
      const file = e.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function(event) {
          currentCover.src = event.target.result;
        }
        reader.readAsDataURL(file);
      }
    });
  }

  // SweetAlert2 untuk konfirmasi hapus
  document.querySelectorAll('.swal-confirm-delete').forEach(button => {
    button.addEventListener('click', function() {
      const id = this.getAttribute('data-id');
      const name = this.getAttribute('data-name');
      
      Swal.fire({
        title: 'Apakah Anda yakin?',
        text: `Anggota "${name}" akan dihapus!`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          // Find the form and submit it
          const form = this.closest('tr').querySelector('form[method="POST"][action*="destroy"]');
          if (form) {
            form.submit();
          }
        }
      });
    });
  });

  // Handle remove cover checkbox
  const removeCoverCheckbox = document.getElementById('removeCover');
  if (removeCoverCheckbox) {
    removeCoverCheckbox.addEventListener('change', function() {
      if (this.checked) {
        coverInput.disabled = true;
      } else {
        coverInput.disabled = false;
      }
    });
  }
});
</script>
@endpush