<?php

namespace App\Http\Controllers;

use App\Models\Lkd;
// (Opsional) jika kamu memang punya model Setting:
use App\Models\Setting;
use Illuminate\View\View;

class LkdPublicController extends Controller
{
    /**
     * Daftar LKD (publik)
     * - hanya yang publish
     * - urut sesuai order_no lalu updated_at terbaru
     * - paginate dengan fallback 12
     */
    public function index(): View
    {
        // Ambil konfigurasi jumlah per halaman dari tabel settings (jika ada),
        // TANPA memanggil method getValue() yang tidak ada.
        $perPage = 12;

        try {
            if (class_exists(Setting::class)) {
                // Ambil kolom "value" dari row dengan key = 'lkd_public_per_page'
                $raw = Setting::where('key', 'lkd_public_per_page')->value('value');
                if (is_numeric($raw) && (int) $raw > 0) {
                    $perPage = (int) $raw;
                }
            }
        } catch (\Throwable $e) {
            // Abaikan jika tabel/Model Setting tidak ada
            $perPage = 12;
        }

        $items = Lkd::query()
            ->published()
            ->ordered()
            ->latest('updated_at')
            ->paginate($perPage);

        return view('lkd.index', compact('items'));
    }

    /**
     * Detail LKD (publik)
     */
    public function show(string $slug): View
    {
        // Tampilkan hanya yang publish
        $lkd = Lkd::query()
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        return view('lkd.show', compact('lkd'));
    }
}
