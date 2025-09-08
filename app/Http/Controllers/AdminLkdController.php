<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\LkdStoreRequest;
use App\Http\Requests\Admin\LkdUpdateRequest;
use App\Models\Lkd;
use App\Models\LkdMember;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminLkdController extends Controller
{
    /**
     * Tampilkan daftar LKD (admin)
     */
    public function index(): View
    {
        $items = Lkd::query()
            ->withCount('members')
            ->ordered()
            ->latest('updated_at')
            ->paginate(12);

        return view('admin.lkd.index', compact('items'));
    }

    /**
     * Form buat LKD
     */
    public function create(): View
    {
        // Siapkan satu baris anggota kosong di form agar UX enak
        $initialMembers = [
            ['nama' => '', 'jabatan' => '', 'kategori' => '', 'kontak' => '', 'order_no' => 0, 'is_active' => true],
        ];

        return view('admin.lkd.create', [
            'initialMembers' => $initialMembers,
        ]);
    }

    /**
     * Simpan LKD + anggota (batch)
     */
    public function store(LkdStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();

        DB::beginTransaction();
        try {
            // Buat LKD
            $lkd = new Lkd();
            $lkd->judul        = $data['judul'];
            $lkd->slug         = $data['slug'] ?? null; // akan otomatis diisi di model jika null
            $lkd->excerpt      = $data['excerpt'] ?? null;
            $lkd->body         = $data['body'] ?? null;
            $lkd->is_published = (bool)($data['is_published'] ?? false);
            $lkd->order_no     = (int)($data['order_no'] ?? 0);
            $lkd->user_id      = auth()->id();
            $lkd->save();

            // Upload cover (jika ada)
            if ($request->hasFile('cover')) {
                $coverPath = $this->storeCover($request->file('cover'));
                $lkd->update(['cover_path' => $coverPath]);
            }

            // Simpan anggota batch (jika ada)
            if (!empty($data['members']) && is_array($data['members'])) {
                foreach ($data['members'] as $m) {
                    // Skip baris kosong total
                    if ($this->isEmptyMemberRow($m)) {
                        continue;
                    }

                    $member = new LkdMember();
                    $member->lkd_id    = $lkd->id;
                    $member->nama      = $m['nama'] ?? '';
                    $member->jabatan   = $m['jabatan'] ?? null;
                    $member->kategori  = $m['kategori'] ?? null;
                    $member->kontak    = $m['kontak'] ?? null;
                    $member->order_no  = (int)($m['order_no'] ?? 0);
                    $member->is_active = (bool)($m['is_active'] ?? true);
                    $member->save();

                    // Upload foto anggota (jika ada)
                    if (!empty($m['foto']) && is_file($m['foto'])) {
                        $fotoPath = $this->storeMemberPhoto($m['foto']);
                        $member->update(['foto_path' => $fotoPath]);
                    }
                }
            }

            DB::commit();
            return redirect()
                ->route('admin.lkd.index')
                ->with('success', 'LKD berhasil dibuat.');
        } catch (\Throwable $e) {
            DB::rollBack();

            // Bersihkan file yang sempat terupload (best effort)
            // Catatan: Untuk menjaga kerapian, bisa dibuat mekanisme cleanup yang lebih detail.

            return back()->withInput()->withErrors([
                'general' => 'Gagal membuat LKD: ' . $e->getMessage(),
            ]);
        }
    }

    /**
     * Form edit LKD
     */
    public function edit(Lkd $lkd): View
    {
        $lkd->load(['members' => function ($q) {
            $q->orderBy('order_no')->orderBy('nama');
        }]);

        return view('admin.lkd.edit', compact('lkd'));
    }

    /**
     * Update LKD + sinkronisasi anggota
     */
    public function update(LkdUpdateRequest $request, Lkd $lkd): RedirectResponse
    {
        $data = $request->validated();

        DB::beginTransaction();
        try {
            // Update data LKD
            $lkd->judul        = $data['judul'];
            $lkd->slug         = $data['slug'] ?? $lkd->slug; // biarkan slug lama jika tidak dikirim
            $lkd->excerpt      = $data['excerpt'] ?? $lkd->excerpt;
            $lkd->body         = $data['body'] ?? $lkd->body;
            $lkd->is_published = (bool)($data['is_published'] ?? false);
            $lkd->order_no     = (int)($data['order_no'] ?? 0);
            $lkd->save();

            // Hapus cover jika diminta
            if (!empty($data['remove_cover']) && $data['remove_cover'] === true) {
                $this->deleteFileIfExists($lkd->cover_path);
                $lkd->update(['cover_path' => null]);
            }

            // Upload cover baru jika ada
            if ($request->hasFile('cover')) {
                // Hapus lama
                $this->deleteFileIfExists($lkd->cover_path);

                $coverPath = $this->storeCover($request->file('cover'));
                $lkd->update(['cover_path' => $coverPath]);
            }

            // Sinkronisasi anggota
            $existingIds = $lkd->members()->pluck('id')->all(); // array of ints
            $touchedIds  = [];

            if (!empty($data['members']) && is_array($data['members'])) {
                foreach ($data['members'] as $row) {
                    // 1) Jika baris ditandai _delete dan punya id → hapus
                    if (!empty($row['_delete']) && !empty($row['id'])) {
                        $member = LkdMember::where('lkd_id', $lkd->id)
                            ->where('id', $row['id'])
                            ->first();
                        if ($member) {
                            $this->deleteFileIfExists($member->foto_path);
                            $member->delete();
                        }
                        $touchedIds[] = (int)$row['id'];
                        continue;
                    }

                    // 2) Jika ada id → update; jika tidak & tidak kosong → create
                    if (!empty($row['id'])) {
                        // UPDATE
                        $member = LkdMember::where('lkd_id', $lkd->id)
                            ->where('id', $row['id'])
                            ->first();

                        if ($member) {
                            // Update kolom
                            $member->nama      = $row['nama'] ?? $member->nama;
                            $member->jabatan   = $row['jabatan'] ?? $member->jabatan;
                            $member->kategori  = $row['kategori'] ?? $member->kategori;
                            $member->kontak    = $row['kontak'] ?? $member->kontak;
                            $member->order_no  = (int)($row['order_no'] ?? $member->order_no);
                            $member->is_active = (bool)($row['is_active'] ?? $member->is_active);
                            $member->save();

                            // Hapus foto anggota jika diminta
                            if (!empty($row['remove_foto']) && $row['remove_foto'] === true) {
                                $this->deleteFileIfExists($member->foto_path);
                                $member->update(['foto_path' => null]);
                            }

                            // Upload foto baru (replace)
                            if (!empty($row['foto']) && is_file($row['foto'])) {
                                $this->deleteFileIfExists($member->foto_path);
                                $fotoPath = $this->storeMemberPhoto($row['foto']);
                                $member->update(['foto_path' => $fotoPath]);
                            }

                            $touchedIds[] = (int)$member->id;
                        }
                    } else {
                        // CREATE baru jika baris tidak kosong
                        if ($this->isEmptyMemberRow($row)) {
                            continue;
                        }
                        $member = new LkdMember();
                        $member->lkd_id    = $lkd->id;
                        $member->nama      = $row['nama'] ?? '';
                        $member->jabatan   = $row['jabatan'] ?? null;
                        $member->kategori  = $row['kategori'] ?? null;
                        $member->kontak    = $row['kontak'] ?? null;
                        $member->order_no  = (int)($row['order_no'] ?? 0);
                        $member->is_active = (bool)($row['is_active'] ?? true);
                        $member->save();

                        // Foto baru (jika ada)
                        if (!empty($row['foto']) && is_file($row['foto'])) {
                            $fotoPath = $this->storeMemberPhoto($row['foto']);
                            $member->update(['foto_path' => $fotoPath]);
                        }

                        $touchedIds[] = (int)$member->id;
                    }
                }
            }

            // 3) (opsional) Hapus anggota yang tidak tersentuh sama sekali pada update ini?
            // -> Biasanya TIDAK dihapus otomatis, karena bisa jadi user sengaja tidak mengubahnya.
            // Jika ingin menghapus yang tidak tersentuh, uncomment blok di bawah:
            /*
            $toDelete = array_diff($existingIds, $touchedIds);
            if (!empty($toDelete)) {
                $members = LkdMember::where('lkd_id', $lkd->id)->whereIn('id', $toDelete)->get();
                foreach ($members as $m) {
                    $this->deleteFileIfExists($m->foto_path);
                    $m->delete();
                }
            }
            */

            DB::commit();
            return redirect()
                ->route('admin.lkd.index')
                ->with('success', 'LKD berhasil diperbarui.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withInput()->withErrors([
                'general' => 'Gagal memperbarui LKD: ' . $e->getMessage(),
            ]);
        }
    }

    /**
     * Hapus LKD + semua anggota + semua file terkait
     */
    public function destroy(Lkd $lkd): RedirectResponse
    {
        DB::beginTransaction();
        try {
            // Hapus cover
            $this->deleteFileIfExists($lkd->cover_path);

            // Hapus foto anggota
            foreach ($lkd->members as $m) {
                $this->deleteFileIfExists($m->foto_path);
            }

            // Hapus anggota & LKD
            $lkd->members()->delete();
            $lkd->delete();

            DB::commit();
            return back()->with('success', 'LKD berhasil dihapus.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors([
                'general' => 'Gagal menghapus LKD: ' . $e->getMessage(),
            ]);
        }
    }

    /* ===============================================================
     | Helper Upload / Delete
     * =============================================================== */

    /**
     * Simpan cover ke disk public (mirip pola Berita).
     * Folder: storage/app/public/lkd/covers
     * Return: path relatif yang disimpan ke DB (mis. 'lkd/covers/xxxx.webp')
     */
    protected function storeCover(\Illuminate\Http\UploadedFile $file): string
    {
        // NB: Jika ingin melakukan resize/convert, lakukan di sini (mis. Intervention Image).
        // Untuk konsistensi dengan Berita yang menyimpan path via Storage::disk('public')->putFile(),
        // gunakan store() ke disk 'public'.
        return $file->store('lkd/covers', 'public');
    }

    /**
     * Simpan foto anggota ke disk public
     * Folder: storage/app/public/lkd/members
     */
    protected function storeMemberPhoto(\Illuminate\Http\UploadedFile $file): string
    {
        return $file->store('lkd/members', 'public');
    }

    /**
     * Hapus file bila ada (disk public)
     */
    protected function deleteFileIfExists(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    /**
     * Cek apakah baris anggota kosong total (untuk menghindari create baris kosong)
     */
    protected function isEmptyMemberRow($row): bool
    {
        if (!is_array($row)) return true;

        $fields = ['nama', 'jabatan', 'kategori', 'kontak'];
        foreach ($fields as $f) {
            if (!empty($row[$f]) && is_string($row[$f]) && trim($row[$f]) !== '') {
                return false;
            }
        }

        // Jika ada foto yang diupload, anggap tidak kosong
        if (!empty($row['foto']) && is_file($row['foto'])) {
            return false;
        }

        // Jika ada nilai numeric yang bukan default, anggap tidak kosong
        if (isset($row['order_no']) && (int)$row['order_no'] !== 0) {
            return false;
        }
        if (!empty($row['is_active'])) {
            return false;
        }

        return true;
        }
        public function slug(Request $request)
    {
    $judul = (string) $request->query('judul', '');
    $base  = \Illuminate\Support\Str::slug($judul);
    $slug  = $base ?: \Illuminate\Support\Str::random(8);

    $i = 1;
    while (\App\Models\Lkd::where('slug', $slug)->exists()) {
        $slug = $base . '-' . $i++;
    }

    return response()->json(['slug' => $slug]);
    }

}
