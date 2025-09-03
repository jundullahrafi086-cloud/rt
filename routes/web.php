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
use App\Http\Controllers\SejarahController;
use App\Http\Controllers\VisiMisiController;
use App\Http\Controllers\PerangkatDesaController;
use App\Http\Controllers\DataDesaController;
use App\Http\Controllers\PetaDesaController;
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
use App\Http\Controllers\AdminJenisKelaminController;
use App\Http\Controllers\AdminAgamaController;
use App\Http\Controllers\AdminVideoProfileController;
use App\Http\Controllers\AdminProfilController;
use App\Http\Controllers\AdminIdentitasSitusController;
use App\Http\Controllers\AdminKepalaDesaController;

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
Route::get('/gallery', [GalleryController::class, 'indexAlbum'])->name('gallery.albums.index');
Route::get('/gallery/{slug}', [GalleryController::class, 'albumDetail'])->name('gallery.albums.detail');

/* Pengumuman (Publik) */
Route::get('/pengumuman', [AnnouncementController::class, 'index']);
Route::get('/pengumuman/{pengumuman:slug}', [AnnouncementController::class, 'detail']);

/* APBDes (Publik) */
Route::get('/apbdesa',              [AnggaranController::class, 'index'])->name('apbdesa.index');
Route::get('/apbdesa/{slug}',       [AnggaranController::class, 'detail'])->name('apbdesa.detail');
Route::get('/apbdesa/{slug}/buka',  [AnggaranController::class, 'open'])->name('apbdesa.open');
Route::get('/apbdesa/{slug}/unduh', [AnggaranController::class, 'download'])->name('apbdesa.download');

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
    Route::resource('gallery', \App\Http\Controllers\AdminGalleryGroupController::class)
        ->parameters(['gallery' => 'album'])
        ->names('admin.gallery');

    Route::get('gallery/slug', [\App\Http\Controllers\AdminGalleryGroupController::class, 'slug'])
        ->name('admin.gallery.slug');

    Route::get('gallery/{album}/foto', [\App\Http\Controllers\AdminGalleryController::class, 'indexByAlbum'])
        ->name('admin.gallery.foto.index');
    Route::post('gallery/{album}/foto', [\App\Http\Controllers\AdminGalleryController::class, 'storeToAlbum'])
        ->name('admin.gallery.foto.store');
    Route::delete('gallery/{album}/foto/{foto}', [\App\Http\Controllers\AdminGalleryController::class, 'destroyFromAlbum'])
        ->name('admin.gallery.foto.destroy');

    /* Pengumuman */
    Route::get('pengumuman/slug', [AdminAnnouncementController::class, 'slug']);
    Route::resource('pengumuman', AdminAnnouncementController::class);

    /* =====================
     * APBDes (ADMIN)
     * ===================== */
    Route::get('apbdes/slug', [AdminAnggaranController::class, 'slug'])
        ->name('admin.apbdes.slug');

    Route::delete('apbdes/{id}/file', [AdminAnggaranController::class, 'removeFile'])
        ->name('admin.apbdes.file.remove');

    Route::resource('apbdes', AdminAnggaranController::class)
        ->parameters(['apbdes' => 'apbde'])
        ->names('admin.apbdes');
});
