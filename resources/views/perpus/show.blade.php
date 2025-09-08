@extends('layouts.main')
@section('title', $buku->judul)

@section('content')
<div class="container py-4">
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
      <li class="breadcrumb-item"><a href="{{ route('perpus.index') }}">Perpus Online</a></li>
      <li class="breadcrumb-item active" aria-current="page">{{ $buku->judul }}</li>
    </ol>
  </nav>

  <div class="card">
    <div class="card-body">
      <h1 class="h4 mb-3">{{ $buku->judul }}</h1>

      @if($buku->deskripsi)
        <article class="prose mb-3">{!! nl2br(e($buku->deskripsi)) !!}</article>
      @else
        <p class="text-muted">Tidak ada deskripsi.</p>
      @endif

      <a href="{{ $buku->link_url }}" class="btn btn-primary" target="_blank">Buka Buku</a>
      <div class="small text-muted mt-2">Sumber: {{ $buku->link_domain }}</div>
    </div>
  </div>
</div>
@endsection
