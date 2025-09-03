@extends('admin.layouts.main')

@section('content')
<div class="card shadow-lg">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0">APBDes</h5>
    <a href="{{ route('admin.apbdes.create') }}" class="btn btn-primary">Tambah</a>
  </div>

  <div class="card-body table-responsive">
    <table class="table table-striped align-middle">
      <thead>
        <tr>
          <th>#</th>
          <th>Judul</th>
          <th>Dokumen</th>
          <th>Diperbarui</th>
          <th width="190">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($items as $i => $row)
          <tr>
            <td>{{ $items->firstItem() + $i }}</td>
            <td>
              <div class="fw-semibold">{{ $row->judul }}</div>
              <div class="text-muted small">/{{ $row->slug }}</div>
            </td>
            <td>
              @if($row->dokumen_path)
                <a href="{{ $row->dokumen_url }}" target="_blank">Lihat</a>
                <div class="text-muted small">{{ $row->dokumen_original }}</div>
              @else
                <span class="text-danger">Belum ada</span>
              @endif
            </td>
            <td>{{ $row->updated_at->format('d M Y H:i') }}</td>
            <td>
              <a class="btn btn-sm btn-secondary" href="{{ route('admin.apbdes.edit', $row->id) }}">Edit</a>
              <form action="{{ route('admin.apbdes.destroy', $row->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data ini?')">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-danger">Hapus</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="5" class="text-center">Belum ada data.</td></tr>
        @endforelse
      </tbody>
    </table>

    {{ $items->links() }}
  </div>
</div>
@endsection
