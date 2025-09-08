@extends('admin.layouts.main')
@section('title','LKD')
@section('content')
<div class="row">
    <div class="col-lg-12 d-flex align-items-strech">
      <div class="card shadow-lg w-100">
        <div class="card-header bg-primary">
            <div class="row align-items-center">
                <div class="col-6">
                    <h5 class="card-title fw-semibold text-white">Lembaga/Kelompok Desa</h5>
                </div>
                <div class="col-6 text-right">
                    <a href="{{ route('lkd.index') }}" type="button" class="btn btn-warning float-end me-2" target="_blank">Live Preview</a>
                </div>
            </div>
        </div>
        
        <div class="card-body">
            @if (session()->has('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="row">
                <div class="button">
                    <a href="{{ route('admin.lkd.create') }}" type="button" class="btn btn-success my-3">Tambah LKD</a>
                </div>
                @foreach ($items as $item)
                  <div class="col-xl-3 my-3" data-aos="fade-up">
                    <div class="member shadow-lg">
                      <div class="pic">
                        @if($item->cover_path)
                          <img src="{{ asset('storage/' . $item->cover_path) }}" class="img-fluid" alt="{{ $item->judul }}" style="border-radius: 5px">
                        @else
                          <img src="{{ asset('images/default-cover.jpg') }}" class="img-fluid" alt="Default Cover" style="border-radius: 5px">
                        @endif
                      </div>
                      <div class="member-info my-2">
                        <h4 class="text-center">{{ $item->judul }}</h4>
                        <p class="text-center">
                          <span class="badge {{ $item->is_published ? 'bg-success' : 'bg-secondary' }}">
                            {{ $item->is_published ? 'Publik' : 'Draft' }}
                          </span>
                        </p>
                        <p class="text-center small text-muted">{{ $item->members_count ?? $item->members()->count() }} Anggota</p>
                        <div class="text-center"> 
                          <a href="{{ route('admin.lkd.edit', $item->id) }}" type="button" class="btn btn-warning">Edit Data</a>
                          <form id="{{ $item->id }}" action="{{ route('admin.lkd.destroy', $item->id) }}" method="POST" class="d-inline">
                            @method('delete')
                            @csrf
                            <button type="button" class="btn btn-danger swal-confirm" data-form="{{ $item->id }}">Hapus</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
              
        </div>
      </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize AOS
    AOS.init({
        duration: 800,
        easing: 'ease-in-out',
        once: true
    });
    
    // SweetAlert2 for delete confirmation
    document.querySelectorAll('.swal-confirm').forEach(button => {
        button.addEventListener('click', function() {
            const formId = this.getAttribute('data-form');
            const form = document.getElementById(formId);
            
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "LKD beserta semua anggotanya akan dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>
@endpush

@push('styles')
<style>
.member {
    background: #fff;
    border-radius: 10px;
    overflow: hidden;
    transition: all 0.3s ease;
    border: 1px solid #e9ecef;
}

.member:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
}

.member .pic {
    height: 200px;
    overflow: hidden;
    position: relative;
}

.member .pic img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: all 0.5s ease;
}

.member:hover .pic img {
    transform: scale(1.05);
}

.member-info {
    padding: 15px;
    text-align: center;
}

.member-info h4 {
    font-size: 1.2rem;
    font-weight: 600;
    margin-bottom: 10px;
    color: #2c3e50;
}

.member-info p {
    margin-bottom: 5px;
    color: #6c757d;
}

.member-info .btn {
    margin: 0 3px;
    border-radius: 5px;
    padding: 5px 15px;
    font-weight: 500;
}

/* Empty state */
.empty-state {
    text-align: center;
    padding: 3rem;
    color: #6c757d;
}

.empty-state i {
    font-size: 3rem;
    color: #dee2e6;
    margin-bottom: 1rem;
}
</style>
@endpush