@extends('admin.layouts.main')

@section('content')
<div class="container-fluid py-3">
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">APBDes</h4>
    <a href="{{ route('apbdes.create') }}" class="btn btn-primary">+ Tambah APBDes</a>
  </div>

  <div class="card">
    <div class="card-body">
      @if($items->count() === 0)
        <p class="text-muted mb-0">Belum ada data.</p>
      @else
      <div class="table-responsive">
        <table class="table align-middle">
          <thead>
            <tr>
              <th style="width:60px">#</th>
              <th>Judul</th>
              <th>Slug</th>
              <th>Dokumen</th>
              <th>Gambar</th>
              <th style="width:160px">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($items as $i => $row)
              <tr>
                <td>{{ $items->firstItem() + $i }}</td>
                <td>{{ $row->judul }}</td>
                <td class="text-muted">{{ $row->slug }}</td>
                <td>
                  @if($row->dokumen_path)
                    <a href="{{ asset('storage/'.$row->dokumen_path) }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                      Unduh
                    </a>
                  @else
                    <span class="text-muted">-</span>
                  @endif
                </td>
                <td>
                  @if($row->gambar)
                    <img src="{{ asset('storage/'.$row->gambar) }}" alt="cover" style="height:40px;object-fit:cover;border-radius:4px;">
                  @else
                    <span class="text-muted">-</span>
                  @endif
                </td>
                <td>
                  <a href="{{ route('apbdes.edit', $row->id) }}" class="btn btn-warning btn-sm">Edit</a>
                  <form action="{{ route('apbdes.destroy', $row->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data ini?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm">Hapus</button>
                  </form>
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
@endsection
