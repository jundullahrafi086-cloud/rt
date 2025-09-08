@extends('admin.layouts.main')

@section('title','LKD')

@section('content')
<div class="row">
  <div class="col-lg-12 d-flex align-items-stretch">
    <div class="card shadow-lg w-100">

      {{-- Header --}}
      <div class="card-header bg-primary">
        <div class="row align-items-center">
          <div class="col-6">
            <h5 class="card-title fw-semibold text-white mb-0">LKD</h5>
            <small class="text-white-50">Kelola Lembaga/Kelompok Desa & anggota</small>
          </div>
          <div class="col-6 text-end">
            <a href="{{ route('admin.lkd.create') }}" class="btn btn-warning">
              <i class="ti ti-plus"></i> Tambah LKD
            </a>
          </div>
        </div>
      </div>

      {{-- Body --}}
      <div class="card-body">

        {{-- Flash --}}
        @if (session('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif
        @if (session('error'))
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        @if ($items->isEmpty())
          <div class="alert alert-info">Belum ada data LKD.</div>
        @else
          <div class="table-responsive">
            <table class="table align-middle">
              <thead>
                <tr>
                  <th style="width:80px">Cover</th>
                  <th>Judul</th>
                  <th>Slug</th>
                  <th class="text-center">Anggota</th>
                  <th class="text-center">Status</th>
                  <th class="text-center" style="width:100px">Urut</th>
                  <th>Diupdate</th>
                  <th style="width:220px">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($items as $lkd)
                  <tr>
                    <td>
                      @if($lkd->cover_url)
                        <img
                          src="{{ $lkd->cover_url }}"
                          alt="cover"
                          class="rounded"
                          style="width:64px;height:48px;object-fit:cover"
                          onerror="this.remove();"
                        >
                      @endif
                    </td>
                    <td class="fw-semibold">
                      <a href="{{ route('lkd.show', $lkd) }}" target="_blank" class="text-decoration-none">
                        {{ $lkd->judul }}
                      </a>
                    </td>
                    <td class="text-muted small">{{ $lkd->slug }}</td>
                    <td class="text-center">{{ $lkd->members_count ?? $lkd->members()->count() }}</td>
                    <td class="text-center">
                      @if ($lkd->is_published)
                        <span class="badge bg-success">publish</span>
                      @else
                        <span class="badge bg-secondary">draft</span>
                      @endif
                    </td>
                    <td class="text-center">{{ $lkd->order_no }}</td>
                    <td class="text-nowrap">{{ optional($lkd->updated_at)->format('d M Y, H:i') }}</td>
                    <td>
                      <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('lkd.show', $lkd) }}" target="_blank" class="btn btn-sm btn-success" title="Lihat Publik">
                          <i class="ti ti-eye"></i>
                        </a>
                        <a href="{{ route('admin.lkd.edit', $lkd) }}" class="btn btn-sm btn-warning" title="Edit">
                          <i class="ti ti-edit"></i>
                        </a>
                        <form
                          action="{{ route('admin.lkd.destroy', $lkd) }}"
                          method="POST"
                          onsubmit="return confirm('Hapus LKD beserta anggota yang terkait?')"
                          class="d-inline"
                        >
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                            <i class="ti ti-trash"></i>
                          </button>
                        </form>
                      </div>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>

          <div class="mt-3">
            {{ $items->links() }}
          </div>
        @endif

      </div>
    </div>
  </div>
</div>
@endsection
