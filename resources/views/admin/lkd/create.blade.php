{{-- resources/views/admin/lkd/create.blade.php --}}
@extends('admin.layouts.main')

@section('title','Tambah LKD')

@section('content')
<style>
  /* ===== UI UPGRADE ===== */
  .member-row {
    border: 1px solid #e9ecef;
    border-radius: 14px;
    padding: 16px;
    margin-bottom: 14px;
    background: #fff;
  }
  .member-row .form-control,
  .member-row .form-select {
    padding: .75rem 1rem;
    font-size: 1rem;
  }
  .member-photo-wrap {
    display: flex;
    align-items: center;
    gap: 12px;
  }
  .member-preview {
    width: 100px;
    height: 100px;
    border-radius: 12px;
    object-fit: cover;
    border: 1px solid #e9ecef;
    background: #f8f9fa;
  }
  .cover-preview {
    width: 100%;
    max-width: 380px;
    height: 210px;
    border-radius: 14px;
    object-fit: cover;
    border: 1px solid #e9ecef;
    background: #f8f9fa;
  }
  .controls-sticky { position: sticky; top: 12px; }
</style>

<div class="row">
  <div class="col-lg-12 d-flex align-items-stretch">
    <div class="card shadow-lg w-100">

      {{-- Header --}}
      <div class="card-header bg-primary">
        <div class="row align-items-center">
          <div class="col-6">
            <h5 class="card-title fw-semibold text-white mb-0">Tambah LKD</h5>
            <small class="text-white-50">Buat Lembaga/Kelompok Desa & tambahkan anggota sekaligus</small>
          </div>
          <div class="col-6 text-end">
            <a href="{{ route('admin.lkd.index') }}" class="btn btn-light" role="button">
              <i class="ti ti-arrow-left"></i> Kembali
            </a>
          </div>
        </div>
      </div>

      {{-- Body --}}
      <div class="card-body">
        <form action="{{ route('admin.lkd.store') }}"
              method="POST"
              enctype="multipart/form-data"
              id="lkdForm"
              autocomplete="off">
          @csrf

          <div class="row g-4">
            <div class="col-lg-8">

              {{-- Judul & Slug --}}
              <div class="mb-3">
                <label class="form-label">Judul <span class="text-danger">*</span></label>
                <input type="text"
                       name="judul"
                       class="form-control form-control-lg @error('judul') is-invalid @enderror"
                       placeholder="contoh: Badan Permusyawaratan Desa (BPD)"
                       value="{{ old('judul') }}"
                       id="judulInput"
                       required>
                @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>

              <div class="mb-3">
                <label class="form-label">Slug <span class="text-danger">*</span></label>
                <div class="input-group input-group-lg">
                  <span class="input-group-text">{{ url('/lkd') }}/</span>
                  <input type="text"
                         name="slug"
                         class="form-control @error('slug') is-invalid @enderror"
                         placeholder="badan-permusyawaratan-desa-bpd"
                         value="{{ old('slug') }}"
                         id="slugInput"
                         required>
                </div>
                <small class="text-muted">Slug dipakai sebagai URL publik.</small>
                @error('slug') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
              </div>

              {{-- Excerpt --}}
              <div class="mb-3">
                <label class="form-label">Ringkasan / Excerpt</label>
                <textarea name="excerpt"
                          class="form-control form-control-lg @error('excerpt') is-invalid @enderror"
                          rows="2"
                          placeholder="Ringkasan singkat (opsional)">{{ old('excerpt') }}</textarea>
                @error('excerpt') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>

              {{-- Body --}}
              <div class="mb-4">
                <label class="form-label">Deskripsi / Struktur</label>
                <textarea name="body"
                          class="form-control form-control-lg @error('body') is-invalid @enderror"
                          rows="6"
                          placeholder="Tulis deskripsi, struktur organisasi, tugas pokok & fungsi, dll.">{{ old('body') }}</textarea>
                @error('body') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>

              {{-- Anggota (Mass Input) --}}
              <div class="d-flex align-items-center justify-content-between mb-2">
                <h5 class="mb-0">Anggota</h5>
                <div class="d-flex gap-2">
                  <button class="btn btn-outline-primary" type="button" id="addMemberBtn">
                    <i class="ti ti-plus"></i> Tambah Anggota
                  </button>
                  <button class="btn btn-outline-secondary" type="button" id="addBatchBtn">
                    <i class="ti ti-list"></i> Tambah 3 Baris
                  </button>
                </div>
              </div>

              <div id="membersList" data-next-index="{{ max(1, count(old('members', []))) }}">
                @php $oldMembers = old('members', []); @endphp

                @forelse ($oldMembers as $idx => $m)
                  <div class="member-row" data-row>
                    <div class="row g-3">
                      <div class="col-md-6">
                        <label class="form-label">Nama</label>
                        <input type="text" name="members[{{ $idx }}][nama]"
                               class="form-control @error("members.$idx.nama") is-invalid @enderror"
                               value="{{ $m['nama'] ?? '' }}" placeholder="Nama lengkap">
                        @error("members.$idx.nama") <div class="invalid-feedback">{{ $message }}</div> @enderror
                      </div>
                      <div class="col-md-6">
                        <label class="form-label">Jabatan</label>
                        <input type="text" name="members[{{ $idx }}][jabatan]"
                               class="form-control @error("members.$idx.jabatan") is-invalid @enderror"
                               value="{{ $m['jabatan'] ?? '' }}" placeholder="Ketua/Anggota/RT 01/…">
                        @error("members.$idx.jabatan") <div class="invalid-feedback">{{ $message }}</div> @enderror
                      </div>

                      <div class="col-md-6">
                        <label class="form-label">Kontak</label>
                        <input type="text" name="members[{{ $idx }}][kontak]"
                               class="form-control @error("members.$idx.kontak") is-invalid @enderror"
                               value="{{ $m['kontak'] ?? '' }}" placeholder="No HP / Email (opsional)">
                        @error("members.$idx.kontak") <div class="invalid-feedback">{{ $message }}</div> @enderror
                      </div>

                      <div class="col-md-6">
                        <label class="form-label">Foto</label>
                        <div class="member-photo-wrap">
                          <input type="file" name="members[{{ $idx }}][foto]"
                                 class="form-control member-foto-input @error("members.$idx.foto") is-invalid @enderror"
                                 accept="image/*">
                          <img class="member-preview d-none" alt="preview">
                        </div>
                        <div class="small text-muted mt-1">jpg,jpeg,png,webp maks 2MB</div>
                        @error("members.$idx.foto") <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                      </div>

                      <div class="col-12 d-flex justify-content-end">
                        <button type="button" class="btn btn-outline-danger removeRowBtn">
                          <i class="ti ti-x"></i> Hapus baris
                        </button>
                      </div>
                    </div>
                  </div>
                @empty
                  {{-- 1 kartu default --}}
                  <div class="member-row" data-row>
                    <div class="row g-3">
                      <div class="col-md-6">
                        <label class="form-label">Nama</label>
                        <input type="text" name="members[0][nama]" class="form-control" placeholder="Nama lengkap">
                      </div>
                      <div class="col-md-6">
                        <label class="form-label">Jabatan</label>
                        <input type="text" name="members[0][jabatan]" class="form-control" placeholder="Ketua/Anggota/RT 01/…">
                      </div>

                      <div class="col-md-6">
                        <label class="form-label">Kontak</label>
                        <input type="text" name="members[0][kontak]" class="form-control" placeholder="No HP / Email (opsional)">
                      </div>

                      <div class="col-md-6">
                        <label class="form-label">Foto</label>
                        <div class="member-photo-wrap">
                          <input type="file" name="members[0][foto]" class="form-control member-foto-input" accept="image/*">
                          <img class="member-preview d-none" alt="preview">
                        </div>
                        <div class="small text-muted mt-1">jpg,jpeg,png,webp maks 2MB</div>
                      </div>

                      <div class="col-12 d-flex justify-content-end">
                        <button type="button" class="btn btn-outline-danger removeRowBtn">
                          <i class="ti ti-x"></i> Hapus baris
                        </button>
                      </div>
                    </div>
                  </div>
                @endforelse
              </div>

            </div>

            <div class="col-lg-4">
              <div class="controls-sticky">

                {{-- Cover --}}
                <div class="mb-3">
                  <label class="form-label">Cover (gambar utama)</label>
                  <input type="file"
                         name="cover"
                         class="form-control @error('cover') is-invalid @enderror"
                         accept="image/*"
                         id="coverInput">
                  <div class="small text-muted">jpg,jpeg,png,webp maks 2MB</div>
                  @error('cover') <div class="invalid-feedback">{{ $message }}</div> @enderror

                  <div class="mt-2">
                    <img id="coverPreview" alt="cover preview" class="cover-preview d-none">
                  </div>
                </div>

                {{-- Publish & Urutan --}}
                <div class="mb-3">
                  <div class="form-check form-switch">
                    <input class="form-check-input"
                           type="checkbox"
                           role="switch"
                           id="publishSwitch"
                           name="is_published"
                           value="1"
                           {{ old('is_published', true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="publishSwitch">Publish</label>
                  </div>
                  @error('is_published') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                <div class="mb-4">
                  <label class="form-label">Nomor Urut</label>
                  <input type="number"
                         name="order_no"
                         class="form-control form-control-lg @error('order_no') is-invalid @enderror"
                         value="{{ old('order_no', 0) }}"
                         min="0" step="1" style="max-width:220px">
                  <small class="text-muted">Semakin kecil semakin atas.</small>
                  @error('order_no') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Actions --}}
                <div class="d-grid gap-2">
                  <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                    <i class="ti ti-device-floppy"></i> Simpan
                  </button>
                  <a href="{{ route('admin.lkd.index') }}" class="btn btn-outline-secondary btn-lg" role="button">
                    Batal
                  </a>
                </div>

              </div>
            </div>
          </div>

        </form>
      </div>

    </div>
  </div>
</div>

{{-- ===== Prototype (disembunyikan). Dipakai untuk clone baris baru ===== --}}
<template id="memberTemplate">
  <div class="member-row" data-row>
    <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label">Nama</label>
        <input type="text" name="__NAME_NAMA__" class="form-control" placeholder="Nama lengkap">
      </div>
      <div class="col-md-6">
        <label class="form-label">Jabatan</label>
        <input type="text" name="__NAME_JABATAN__" class="form-control" placeholder="Ketua/Anggota/RT 01/…">
      </div>
      <div class="col-md-6">
        <label class="form-label">Kontak</label>
        <input type="text" name="__NAME_KONTAK__" class="form-control" placeholder="No HP / Email (opsional)">
      </div>
      <div class="col-md-6">
        <label class="form-label">Foto</label>
        <div class="member-photo-wrap">
          <input type="file" name="__NAME_FOTO__" class="form-control member-foto-input" accept="image/*">
          <img class="member-preview d-none" alt="preview">
        </div>
        <div class="small text-muted mt-1">jpg,jpeg,png,webp maks 2MB</div>
      </div>
      <div class="col-12 d-flex justify-content-end">
        <button type="button" class="btn btn-outline-danger removeRowBtn">
          <i class="ti ti-x"></i> Hapus baris
        </button>
      </div>
    </div>
  </div>
</template>
@endsection

@push('scripts')
<script>
  // Pastikan helper onDomReady tersedia dari layout
  window.onDomReady(function () {
    /* ---------- Util ---------- */
    function slugify(str) {
      return (str || '')
        .toString()
        .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
        .replace(/[^a-zA-Z0-9\s-]/g, '')
        .trim()
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-')
        .toLowerCase();
    }

    /* ---------- Elemen dasar ---------- */
    const form         = document.getElementById('lkdForm');
    const submitBtn    = document.getElementById('submitBtn');
    const judulInput   = document.getElementById('judulInput');
    const slugInput    = document.getElementById('slugInput');
    const coverInput   = document.getElementById('coverInput');
    const coverPreview = document.getElementById('coverPreview');

    const membersList  = document.getElementById('membersList');
    const addBtn       = document.getElementById('addMemberBtn');
    const add3Btn      = document.getElementById('addBatchBtn');
    const tpl          = document.getElementById('memberTemplate');

    /* ---------- Slug otomatis ---------- */
    let slugUserEdited = false;
    if (slugInput) slugInput.addEventListener('input', () => slugUserEdited = true);
    if (judulInput && slugInput) {
      judulInput.addEventListener('input', function () {
        if (!slugUserEdited) slugInput.value = slugify(this.value);
      });
    }

    /* ---------- Cegah submit ganda ---------- */
    if (form && submitBtn) {
      form.addEventListener('submit', function () {
        submitBtn.disabled = true;
        submitBtn.innerHTML =
          '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Menyimpan...';
      });
    }

    /* ---------- Preview cover ---------- */
    if (coverInput && coverPreview) {
      coverInput.addEventListener('change', function (e) {
        const f = e.target.files && e.target.files[0];
        if (!f) { coverPreview.classList.add('d-none'); return; }
        const reader = new FileReader();
        reader.onload = ev => { coverPreview.src = ev.target.result; coverPreview.classList.remove('d-none'); };
        reader.readAsDataURL(f);
      });
    }

    /* ---------- Helper index ---------- */
    function getNextIndex() {
      // Ambil dari data attribute agar akurat & tidak perlu scan DOM
      let idx = parseInt(membersList.getAttribute('data-next-index') || '0', 10);
      if (Number.isNaN(idx)) idx = 0;
      membersList.setAttribute('data-next-index', String(idx + 1));
      return idx;
    }

    /* ---------- Buat elemen dari template ---------- */
    function createMemberRow() {
      const idx = getNextIndex();
      const html = tpl.innerHTML
        .replaceAll('__NAME_NAMA__',    `members[${idx}][nama]`)
        .replaceAll('__NAME_JABATAN__', `members[${idx}][jabatan]`)
        .replaceAll('__NAME_KONTAK__',  `members[${idx}][kontak]`)
        .replaceAll('__NAME_FOTO__',    `members[${idx}][foto]`);
      const wrapper = document.createElement('div');
      wrapper.innerHTML = html.trim();
      return wrapper.firstElementChild;
    }

    /* ---------- Tambah 1 & Tambah 3 ---------- */
    if (addBtn && membersList) {
      addBtn.addEventListener('click', function (e) {
        e.preventDefault();
        const row = createMemberRow();
        membersList.appendChild(row);
        const nameField = row.querySelector('input[name$="[nama]"]');
        if (nameField) nameField.focus();
      });
    }

    if (add3Btn && membersList) {
      add3Btn.addEventListener('click', function (e) {
        e.preventDefault();
        const frag = document.createDocumentFragment();
        for (let i = 0; i < 3; i++) {
          frag.appendChild(createMemberRow());
        }
        membersList.appendChild(frag);
      });
    }

    /* ---------- Delegasi: hapus baris & preview foto anggota ---------- */
    if (membersList) {
      // Hapus baris
      membersList.addEventListener('click', function (e) {
        const btn = e.target.closest('.removeRowBtn');
        if (!btn) return;
        const rows = membersList.querySelectorAll('[data-row]');
        if (rows.length <= 1) return; // sisakan minimal 1 kartu
        const row = btn.closest('[data-row]');
        if (row) row.remove();
      });

      // Preview foto anggota
      membersList.addEventListener('change', function (e) {
        if (!e.target.matches('.member-foto-input')) return;
        const file = e.target.files && e.target.files[0];
        const img  = e.target.closest('.member-photo-wrap')?.querySelector('.member-preview');
        if (!img) return;
        if (!file) { img.classList.add('d-none'); return; }
        const reader = new FileReader();
        reader.onload = ev => { img.src = ev.target.result; img.classList.remove('d-none'); };
        reader.readAsDataURL(file);
      });
    }
  });
</script>
@endpush
