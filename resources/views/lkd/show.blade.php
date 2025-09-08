@extends('layouts.main')

@section('title', $lkd->judul)

@section('content')
<div class="container py-4">
  {{-- Header --}}
  <div class="row align-items-center g-3 mb-4">
    <div class="col-12 col-md-auto">
      <img
        src="{{ $lkd->cover_url }}"
        alt="{{ $lkd->judul }}"
        class="rounded shadow-sm"
        style="width:180px;height:120px;object-fit:cover"
        onerror="this.src='{{ asset('images/placeholders/Bpd.jpg') }}';"
      >
    </div>
    <div class="col">
      <h1 class="h3 mb-1">{{ $lkd->judul }}</h1>
      <div class="text-muted small">
        Diperbarui {{ optional($lkd->updated_at)->format('d M Y, H:i') }}
      </div>
    </div>
  </div>

  {{-- Body/Deskripsi --}}
  @if(!empty($lkd->body))
    <div class="mb-4">
      <div class="content-body">{!! $lkd->body !!}</div>
    </div>
  @endif

  {{-- Struktur / Anggota --}}
  <div class="d-flex align-items-center justify-content-between mb-3">
    <h2 class="h5 mb-0">Struktur / Anggota</h2>
    <div class="text-muted small">{{ $lkd->members->count() }} anggota</div>
  </div>

  @if($lkd->members->isEmpty())
    <div class="alert alert-info">Belum ada data anggota untuk LKD ini.</div>
  @else
    <div class="row g-4">
      @foreach($lkd->members as $m)
        <div class="col-12 col-sm-6 col-lg-4">
          <div class="card h-100 shadow-sm">
            <div class="d-flex align-items-center p-3 pb-0">
              <img
                src="{{ $m->photo_url }}"
                alt="{{ $m->nama }}"
                class="rounded-circle border"
                style="width:64px;height:64px;object-fit:cover"
                onerror="this.src='{{ asset('images/placeholders/avatar.png') }}';"
              >
              <div class="ms-3">
                <div class="fw-semibold">{{ $m->nama }}</div>
                @if(!empty($m->jabatan))
                  <div class="text-muted small">{{ $m->jabatan }}</div>
                @endif
              </div>
            </div>

            <div class="card-body">
              @if(!empty($m->keterangan))
                <div class="text-muted small mb-2">{!! nl2br(e($m->keterangan)) !!}</div>
              @endif

              <div class="table-responsive">
                <table class="table table-sm table-borderless mb-0">
                  @if(!empty($m->telepon))
                    <tr>
                      <td class="text-muted small" style="width:90px;">Telepon</td>
                      <td class="small">
                        <a href="tel:{{ $m->telepon }}">{{ $m->telepon }}</a>
                      </td>
                    </tr>
                  @endif
                  @if(!empty($m->email))
                    <tr>
                      <td class="text-muted small">Email</td>
                      <td class="small">
                        <a href="mailto:{{ $m->email }}">{{ $m->email }}</a>
                      </td>
                    </tr>
                  @endif
                  @if(!empty($m->alamat))
                    <tr>
                      <td class="text-muted small">Alamat</td>
                      <td class="small">{{ $m->alamat }}</td>
                    </tr>
                  @endif
                </table>
              </div>
            </div>

            <div class="card-footer bg-white d-flex justify-content-between align-items-center">
              <span class="badge {{ $m->is_active ? 'bg-success' : 'bg-secondary' }}">
                {{ $m->is_active ? 'Aktif' : 'Nonaktif' }}
              </span>
              @if(!empty($m->order_no))
                <small class="text-muted">Urut: {{ $m->order_no }}</small>
              @endif
            </div>
          </div>
        </div>
      @endforeach
    </div>
  @endif
</div>
@endsection
