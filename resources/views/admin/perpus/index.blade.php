@extends('admin.layouts.main')

@section('title','Perpus Online')

@section('content')
<div class="row">
  <div class="col-lg-12 d-flex align-items-stretch">
    <div class="card shadow-lg w-100">
      <div class="card-header bg-primary">
        <div class="row align-items-center">
          <div class="col-6">
            <h5 class="card-title fw-semibold text-white mb-0">Perpus Online</h5>
          </div>
          <div class="col-6 text-right">
            <a href="{{ route('admin.perpus.create') }}" class="btn btn-warning float-end">Tambah Buku</a>
          </div>
        </div>
      </div>

      <div class="card-body">
        @if (session()->has('success'))
          <div class="alert alert-success" role="alert">
            {{ session('success') }}
          </div>
        @endif

        <div class="table-responsive">
          <table id="table_perpus" class="table display">
            <thead>
              <tr>
                <th style="width:60px;">No</th>
                <th>Judul</th>
                <th>Link</th>
                <th>Terakhir Diupdate</th>
                <th style="width:200px;">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($items as $i => $b)
                <tr>
                  <td>{{ $items->firstItem() + $i }}</td>
                  <td>
                    <div class="fw-semibold">{{ $b->judul }}</div>
                    <div class="small text-muted">{{ $b->slug }}</div>
                  </td>
                  <td>
                    <a href="{{ $b->link_url }}" target="_blank" class="text-truncate d-inline-block" style="max-width:340px;">
                      {{ $b->link_url }}
                    </a>
                    <div class="small text-muted">{{ $b->link_domain }}</div>
                  </td>
                  <td class="text-nowrap">{{ optional($b->updated_at)->format('d M Y, H:i') }}</td>
                  <td>
                    <div class="d-flex flex-wrap gap-2">
                      <a href="{{ route('perpus.show', $b->slug) }}" target="_blank" class="btn btn-success btn-sm" title="Lihat">
                        <i class="ti ti-eye-check"></i>
                      </a>
                      <a href="{{ route('admin.perpus.edit', $b) }}" class="btn btn-warning btn-sm" title="Edit">
                        <i class="ti ti-edit"></i>
                      </a>
                      <form id="form-{{ $b->id }}" action="{{ route('admin.perpus.destroy', $b) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger btn-sm swal-confirm" data-form="form-{{ $b->id }}" title="Hapus">
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

        {{-- Pagination (jaga-jaga bila tidak memakai DataTables server-side) --}}
        <div class="mt-3">
          {{ $items->links() }}
        </div>
      </div>
    </div>
  </div>
</div>

{{-- DataTables init mengikuti halaman Berita --}}
<script>
  $(document).ready(function () {
    $('#table_perpus').DataTable();

    // konfirmasi hapus ala Berita (pakai data-form)
    $('.swal-confirm').on('click', function () {
      const formId = $(this).data('form');
      if (confirm('Anda yakin ingin menghapus buku ini?')) {
        document.getElementById(formId).submit();
      }
    });
  });
</script>
@endsection
