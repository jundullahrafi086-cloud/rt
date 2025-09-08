<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class LkdStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Pastikan route ini berada di grup middleware 'auth'
        // Jika perlu pembatasan role, tambahkan policy/gate di sini.
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            // Data LKD
            'judul'         => ['required', 'string', 'max:255'],
            'slug'          => ['nullable', 'string', 'max:255', 'unique:lkds,slug'],
            'excerpt'       => ['nullable', 'string'],
            'body'          => ['nullable', 'string'],
            'is_published'  => ['nullable', 'boolean'],
            'order_no'      => ['nullable', 'integer', 'min:0'],

            // Cover LKD (meniru logika berita: simpan ke disk 'public')
            'cover'         => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'], // 4MB

            // Anggota (input batch)
            'members'                       => ['nullable', 'array'],
            'members.*.nama'                => ['required_with:members', 'string', 'max:255'],
            'members.*.jabatan'             => ['nullable', 'string', 'max:255'],
            'members.*.kategori'            => ['nullable', 'string', 'max:100'],
            'members.*.kontak'              => ['nullable', 'string', 'max:255'],
            'members.*.order_no'            => ['nullable', 'integer', 'min:0'],
            'members.*.is_active'           => ['nullable', 'boolean'],
            'members.*.foto'                => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'], // 4MB per foto
        ];
    }

    public function attributes(): array
    {
        return [
            'judul'                 => 'judul',
            'slug'                  => 'slug',
            'excerpt'               => 'ringkasan',
            'body'                  => 'isi',
            'cover'                 => 'cover LKD',
            'members'               => 'anggota',
            'members.*.nama'        => 'nama anggota',
            'members.*.jabatan'     => 'jabatan anggota',
            'members.*.kategori'    => 'kategori anggota',
            'members.*.kontak'      => 'kontak anggota',
            'members.*.order_no'    => 'urutan anggota',
            'members.*.is_active'   => 'status aktif anggota',
            'members.*.foto'        => 'foto anggota',
        ];
    }

    public function messages(): array
    {
        return [
            'cover.image'      => 'File cover harus berupa gambar.',
            'cover.mimes'      => 'Cover hanya boleh: jpg, jpeg, png, webp.',
            'cover.max'        => 'Ukuran cover maks 4MB.',
            'members.*.foto.image' => 'File foto anggota harus berupa gambar.',
            'members.*.foto.mimes' => 'Foto anggota hanya boleh: jpg, jpeg, png, webp.',
            'members.*.foto.max'   => 'Ukuran foto anggota maks 4MB.',
            'slug.unique'          => 'Slug sudah digunakan.',
        ];
    }

    /**
     * Normalisasi input agar konsisten.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_published' => (bool) $this->boolean('is_published'),
        ]);
    }
}
