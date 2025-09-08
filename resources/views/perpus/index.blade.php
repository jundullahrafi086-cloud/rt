@extends('layouts.main')
@section('title','Perpus Online')

@section('content')
<div class="container py-4">
    {{-- Bagian Header dan Pencarian --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
        <h1 class="mb-0 h2">Perpus Online</h1>
        <form method="GET" class="d-flex" action="{{ route('perpus.index') }}">
            <input type="text" class="form-control me-2" name="q" placeholder="Cari judul buku..." value="{{ $q ?? '' }}">
            <button class="btn btn-primary">Cari</button>
        </form>
    </div>

    @if($items->isEmpty())
        <div class="alert alert-info text-center">
            <h4 class="alert-heading">Buku tidak ditemukan</h4>
            <p>Belum ada data buku yang cocok dengan pencarian Anda atau data buku masih kosong.</p>
        </div>
    @else
        {{-- Mengubah list menjadi grid card --}}
        <div class="row g-4">
            @foreach($items as $b)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm border-0">
                        {{-- Menambahkan placeholder untuk gambar cover --}}
                        <img src="https://via.placeholder.com/400x250/dee2e6/6c757d.png?text=Cover+Buku" class="card-img-top" alt="Cover Buku">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $b->judul }}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">{{ $b->link_domain }}</h6>
                            
                            {{-- Tombol diletakkan di bagian bawah card --}}
                            <div class="mt-auto d-flex gap-2">
                                <a href="{{ $b->link_url }}" target="_blank" class="btn btn-sm btn-primary w-100">
                                    <i class="bi bi-box-arrow-up-right me-1"></i> Buka
                                </a>
                                <a href="{{ route('perpus.show', $b->slug) }}" class="btn btn-sm btn-outline-secondary w-100">
                                    <i class="bi bi-info-circle me-1"></i> Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Paginasi --}}
        <div class="mt-4 d-flex justify-content-center">
            {{ $items->links() }}
        </div>
    @endif
</div>
@endsection