<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| PUBLIC CONTROLLERS
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\kategoriController; // (biarkan sesuai nama class yang kamu pakai)
use App\Http\Controllers\WilayahController;
use App\Http\Controllers\LkdPublicController;
use App\Http\Controllers\AdminLkdController;
use App\Http\Controllers\SejarahController;
use App\Http\Controllers\VisiMisiController;
use App\Http\Controllers\PerangkatDesaController;
use App\Http\Controllers\DataDesaController;
use App\Http\Controllers\PetaDesaController;
use App\Http\Controllers\PerpusController; 
use App\Http\Controllers\UmkmController;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\GalleryController;       // publik
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AnggaranController;      // publik APBDes
use App\Http\Controllers\CommentController;

/*
|--------------------------------------------------------------------------
| ADMIN CONTROLLERS
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\AdminSliderController;
use App\Http\Controllers\AdminBeritaController;
use App\Http\Controllers\AdminKategoriController;
use App\Http\Controllers\AdminWilayahController;
use App\Http\Controllers\AdminSejarahController;
use App\Http\Controllers\AdminVisiMisiController;
use App\Http\Controllers\AdminCommentController;
use App\Http\Controllers\AdminPerangkatDesaController;
use App\Http\Controllers\AdminPetaController;
use App\Http\Controllers\AdminUmkmController;
use App\Http\Controllers\AdminKontakController;
use App\Http\Controllers\AdminLayananController;
// ⬇️ Untuk menghindari error missing import, bagian Gallery Admin akan pakai FQCN langsung di route.
use App\Http\Controllers\AdminAnnouncementController;
use App\Http\Controllers\AdminAnggaranController;
use App\Http\Controllers\AdminPekerjaanController;
use App\Http\Controllers\AdminPerpusController; 
use App\Http\Controllers\AdminJenisKelaminController;
use App\Http\Controllers\AdminAgamaController;
use App\Http\Controllers\AdminVideoProfileController;
use App\Http\Controllers\AdminProfilController;
use App\Http\Controllers\AdminIdentitasSitusController;
use App\Http\Controllers\AdminKepalaDesaController;
use App\Http\Controllers\AdminGalleryGroupController;
use App\Http\Controllers\AdminGalleryController;
/*
|--------------------------------------------------------------------------
| WEB ROUTES
|--------------------------------------------------------------------------
*/

/* =====================
 * HALAMAN PUBLIK
 * ===================== */
Route::get('/', [BerandaController::class, 'index'])->name('home');

Route::get('/berita', [BeritaController::class, 'index']);
Route::get('/berita/{beritas:slug}', [BeritaController::class, 'berita']);
Route::post('/berita/{slug}', [CommentController::class, 'comment']);
Route::post('/berita/{slug}/reply', [CommentController::class, 'commentReply']);
Route::get('/perpus', [PerpusController::class, 'index'])->name('perpus.index');
// (opsional) detail buku:
Route::get('/perpus/{slug}', [PerpusController::class, 'show'])->name('perpus.show');

// LKD (Publik)
Route::get('/lkd', [LkdPublicController::class, 'index'])->name('lkd.index');
Route::get('/lkd/{slug}', [LkdPublicController::class, 'show'])->name('lkd.show');


Route::get('/kategori/{kategori:slug}', [kategoriController::class, 'index']);
Route::get('/wilayah', [WilayahController::class, 'index']);
Route::get('/sejarah', [SejarahController::class, 'index'])->name('sejarah.index');
Route::get('/visi-misi', [VisiMisiController::class, 'index']);
Route::get('/perangkat-desa', [PerangkatDesaController::class, 'index']);
Route::get('/data-desa', [DataDesaController::class, 'index']);
Route::get('/peta-desa', [PetaDesaController::class, 'index']);
Route::get('/umkm', [UmkmController::class, 'index']);
Route::get('/umkm/{umkm:slug}', [UmkmController::class, 'detail']);
Route::get('/kontak', [KontakController::class, 'index']);
Route::get('/layanan', [LayananController::class, 'index']);


/* GALERI (Publik) */
Route::get('/gallery', [GalleryController::class, 'index']);
/* Pengumuman (Publik) */
Route::get('/pengumuman', [AnnouncementController::class, 'index']);
Route::get('/pengumuman/{pengumuman:slug}', [AnnouncementController::class, 'detail']);

/* APBDes (Publik) */
Route::get('/apbdesa', [\App\Http\Controllers\AnggaranController::class, 'index'])->name('apbdesa.index');
Route::get('/apbdesa/{anggaran:slug}', [\App\Http\Controllers\AnggaranController::class, 'detail'])->name('apbdesa.detail');

// BARU: open & download dokumen
Route::get('/apbdesa/{anggaran:slug}/open', [AnggaranController::class, 'open'])->name('apbdes.open');
Route::get('/apbdesa/{anggaran:slug}/download', [AnggaranController::class, 'download'])->name('apbdesa.download');
/* =====================
 * AUTH & DASHBOARD
 * ===================== */
Auth::routes();
Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

/* =====================
 * ADMIN AREA (auth)
 * ===================== */
Route::prefix('admin')->middleware(['auth'])->group(function () {

    /* Slider */
    Route::resource('slider', AdminSliderController::class);

    /* Berita */
    Route::get('berita/slug', [AdminBeritaController::class, 'slug']);
    Route::resource('berita', AdminBeritaController::class);

    Route::get('perpus/slug', [AdminPerpusController::class, 'slug'])->name('admin.perpus.slug');

    // Resource (pakai parameter khusus agar tidak bentrok nama)
    Route::resource('perpus', AdminPerpusController::class)
        ->parameters(['perpus' => 'perpu'])
        ->names('admin.perpus');

    /* Kategori */
    Route::get('kategori/slug', [AdminKategoriController::class, 'slug']);
    Route::resource('kategori', AdminKategoriController::class);

    /* Wilayah */
    Route::get('wilayah', [AdminWilayahController::class, 'index']);
    Route::get('wilayah/{id}/edit', [AdminWilayahController::class, 'edit']);
    Route::put('wilayah/{id}', [AdminWilayahController::class, 'update']);

    /* Sejarah */
    Route::get('sejarah', [AdminSejarahController::class, 'index']);
    Route::get('sejarah/{id}/edit', [AdminSejarahController::class, 'edit']);
    Route::put('sejarah/{id}', [AdminSejarahController::class, 'update']);

    /* Kepala Desa (Periode) */
    Route::resource('kepala-desa', AdminKepalaDesaController::class)->names([
        'index'   => 'kepala-desa.index',
        'create'  => 'kepala-desa.create',
        'store'   => 'kepala-desa.store',
        'edit'    => 'kepala-desa.edit',
        'update'  => 'kepala-desa.update',
        'destroy' => 'kepala-desa.destroy',
    ]);

    // ENDPOINT BANTUAN (AJAX ONLY)
     Route::get('lkd/slug', [AdminLkdController::class, 'slug'])
        ->name('admin.lkd.slug');

    Route::post('lkd/limit', [AdminLkdController::class, 'updateLimit'])
        ->name('admin.lkd.limit');

    // 2) Baru resource-nya
    Route::resource('lkd', AdminLkdController::class)
        ->parameters(['lkd' => 'lkd'])
        ->names('admin.lkd');


    /* Komentar */
    Route::get('komentar', [AdminCommentController::class, 'index'])->name('komentar.index');
    Route::delete('komentar/{id}', [AdminCommentController::class, 'destroy'])->name('komentar.destroy');

    /* Visi Misi */
    Route::get('visi-misi', [AdminVisiMisiController::class, 'index']);
    Route::get('visi-misi/{id}/edit', [AdminVisiMisiController::class, 'edit']);
    Route::put('visi-misi/{id}', [AdminVisiMisiController::class, 'update']);

    /* Perangkat Desa */
    Route::resource('perangkat-desa', AdminPerangkatDesaController::class);

    /* Peta Desa */
    Route::get('peta-desa', [AdminPetaController::class, 'index']);
    Route::put('peta-desa/{id}', [AdminPetaController::class, 'update']);

    /* Agama */
    Route::resource('agama', AdminAgamaController::class);


    /* Jenis Kelamin */
    Route::resource('jenis-kelamin', AdminJenisKelaminController::class);

    /* Pekerjaan */
    Route::resource('pekerjaan', AdminPekerjaanController::class);

    /* UMKM */
    Route::get('umkm/slug', [AdminUmkmController::class, 'slug']);
    Route::resource('umkm', AdminUmkmController::class);

    /* Kontak */
    Route::get('kontak', [AdminKontakController::class, 'index']);
    Route::put('kontak/{id}', [AdminKontakController::class, 'update']);

    /* Video Profile */
    Route::get('video-profile', [AdminVideoProfileController::class, 'index']);
    Route::put('video-profile/{id}', [AdminVideoProfileController::class, 'update']);

    /* Identitas Situs */
    Route::get('identitas-situs', [AdminIdentitasSitusController::class, 'index']);
    Route::put('identitas-situs/{id}', [AdminIdentitasSitusController::class, 'update']);

    /* Profil Admin */
    Route::get('profil', [AdminProfilController::class, 'index']);
    Route::put('profil/{id}', [AdminProfilController::class, 'update']);
    Route::put('profil', [AdminProfilController::class, 'changePassword']); // atau POST ke 'profil/password'

    /* Layanan */
    Route::resource('layanan', AdminLayananController::class);

    /* =====================
     * GALLERY (ADMIN) — gunakan FQCN agar tidak error missing import
     * ===================== */
   
   Route::resource('gallery', AdminGalleryController::class);

    /* =====================
     * APBDes (ADMIN)
     * ===================== */
    Route::get('apbdes/slug', [AdminAnggaranController::class, 'slug'])->name('apbdes.slug');
    Route::resource('apbdes', AdminAnggaranController::class);

});
