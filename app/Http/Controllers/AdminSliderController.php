<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminSliderController extends Controller
{
    /**
     * Tampilkan semua slide (opsional: pagination).
     */
    public function index()
    {
        // pakai pagination kalau daftar bisa panjang:
        $sliders = Slider::orderByDesc('id')->paginate(12);

        return view('admin.slider.index', compact('sliders'));
    }

    /**
     * Form buat slide baru.
     */
    public function create()
    {
        return view('admin.slider.create');
    }

    /**
     * Simpan slide baru.
     */
    public function store(Request $request)
    {
        $rules = [
            'img_slider' => 'required|image|mimes:jpg,jpeg,png,webp|max:4096',
            'judul'      => 'required|string|max:255',
            'deskripsi'  => 'required|string',
            'link_btn'   => 'nullable|string|max:255',
        ];
        $validator = Validator::make($request->all(), $rules, [
            'img_slider.required' => 'Gambar wajib diunggah.',
            'img_slider.image'    => 'File harus berupa gambar.',
            'judul.required'      => 'Judul wajib diisi.',
            'deskripsi.required'  => 'Deskripsi wajib diisi.',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $path = $request->file('img_slider')->store('img-slider', 'public');

        $data = [
            'judul'      => $request->judul,
            'deskripsi'  => $request->deskripsi,
            'link_btn'   => $request->link_btn,
            'img_slider' => $path,
        ];

        // kalau tabel punya kolom user_id, simpan pemiliknya
        if (\Schema::hasColumn('sliders', 'user_id') && auth()->check()) {
            $data['user_id'] = auth()->id();
        }

        Slider::create($data);

        return redirect()->route('slider.index')->with('success', 'Slide berhasil ditambahkan.');
    }

    /**
     * Form edit.
     */
    public function edit(Slider $slider)
    {
        return view('admin.slider.edit', compact('slider'));
    }

    /**
     * Update slide.
     */
    public function update(Request $request, Slider $slider)
    {
        $rules = [
            'img_slider' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'judul'      => 'required|string|max:255',
            'deskripsi'  => 'required|string',
            'link_btn'   => 'nullable|string|max:255',
        ];
        $validator = Validator::make($request->all(), $rules, [
            'judul.required'     => 'Judul wajib diisi.',
            'deskripsi.required' => 'Deskripsi wajib diisi.',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $imgPath = $slider->img_slider;
        if ($request->hasFile('img_slider')) {
            if ($imgPath && Storage::disk('public')->exists($imgPath)) {
                Storage::disk('public')->delete($imgPath);
            }
            $imgPath = $request->file('img_slider')->store('img-slider', 'public');
        }

        $data = [
            'judul'      => $request->judul,
            'deskripsi'  => $request->deskripsi,
            'link_btn'   => $request->link_btn,
            'img_slider' => $imgPath,
        ];

        if (\Schema::hasColumn('sliders', 'user_id') && auth()->check()) {
            $data['user_id'] = auth()->id();
        }

        $slider->update($data);

        return redirect()->route('slider.index')->with('success', 'Slide berhasil diperbarui.');
    }

    /**
     * Hapus slide.
     */
    public function destroy(Slider $slider)
    {
        if ($slider->img_slider && Storage::disk('public')->exists($slider->img_slider)) {
            Storage::disk('public')->delete($slider->img_slider);
        }
        $slider->delete();

        return redirect()->route('slider.index')->with('success', 'Slide berhasil dihapus.');
    }
}
