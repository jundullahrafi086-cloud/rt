<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LkdUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        // Ambil ID LKD dari route model binding
        // Pastikan resource route-mu menggunakan parameter {lkd} dan binding ke App\Models\Lkd
        $lkd = $this->route('lkd'); // bisa object model atau id (tergantung binding)
        $lkdId = is_object($lkd) ? $lkd->getKey() : (int) $lkd;

        return [
            // Data LKD
            'judul'         => ['required', 'string', 'max:255'],
            'slug'          => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('lkds', 'slug')->ignore($lkdId),
            ],
            'excerpt'       => ['nullable', 'string'],
            'body'          => ['nullable', 'string'],
            'is_published'  => ['nullable', 'boolean'],
            'order_no'      => ['nullable', 'integer', 'min:0'],

            // Cover update/hapus
            'cover'         => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'], // 4MB
            'remove_cover'  => ['nullable', 'boolean'],

            // Anggota (batch)
            'members'                       => ['nullable', 'array'],

            // id anggota yang sudah ada (boleh null untuk anggota baru)
            'members.*.id'                  => ['nullable', 'integer', 'exists:lkd_members,id'],

            // soft flag untuk hapus baris anggota (jika true, baris ini dihapus)
            'members.*._delete'             => ['nullable', 'boolean'],

            'members.*.nama'                => ['required_without:members.*._delete', 'string', 'max:255'],
            'members.*.jabatan'             => ['nullable', 'string', 'max:255'],
            'members.*.kategori'            => ['nullable', 'string', 'max:100'],
            'members.*.kontak'              => ['nullable', 'string', 'max:255'],
            'members.*.order_no'            => ['nullable', 'integer', 'min:0'],
            'members.*.is_active'           => ['nullable', 'boolean'],

            // Foto anggota baru/pengganti
            'members.*.foto'                => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            // Untuk menghapus foto anggota
            'members.*.remove_foto'         => ['nullable', 'boolean'],
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
            'remove_cover'          => 'hapus cover',
            'members'               => 'anggota',
            'members.*.id'          => 'ID anggota',
            'members.*._delete'     => 'hapus anggota',
            'members.*.nama'        => 'nama anggota',
            'members.*.jabatan'     => 'jabatan anggota',
            'members.*.kategori'    => 'kategori anggota',
            'members.*.kontak'      => 'kontak anggota',
            'members.*.order_no'    => 'urutan anggota',
            'members.*.is_active'   => 'status aktif anggota',
            'members.*.foto'        => 'foto anggota',
            'members.*.remove_foto' => 'hapus foto anggota',
        ];
    }

    public function messages(): array
    {
        return [
            'slug.unique'              => 'Slug sudah digunakan.',
            'cover.image'              => 'File cover harus berupa gambar.',
            'cover.mimes'              => 'Cover hanya boleh: jpg, jpeg, png, webp.',
            'cover.max'                => 'Ukuran cover maks 4MB.',
            'members.*.foto.image'     => 'File foto anggota harus berupa gambar.',
            'members.*.foto.mimes'     => 'Foto anggota hanya boleh: jpg, jpeg, png, webp.',
            'members.*.foto.max'       => 'Ukuran foto anggota maks 4MB.',
            'members.*.nama.required_without' => 'Nama wajib diisi kecuali baris anggota ditandai untuk dihapus.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_published' => (bool) $this->boolean('is_published'),
            'remove_cover' => (bool) $this->boolean('remove_cover'),
        ]);

        // Normalisasi flags anggota
        $members = $this->input('members', []);
        if (is_array($members)) {
            foreach ($members as $i => $m) {
                if (!is_array($m)) continue;

                $m['_delete']     = isset($m['_delete']) ? (bool) $m['_delete'] : false;
                $m['is_active']   = isset($m['is_active']) ? (bool) $m['is_active'] : false;
                $m['remove_foto'] = isset($m['remove_foto']) ? (bool) $m['remove_foto'] : false;

                // Trim teks umum
                foreach (['nama','jabatan','kategori','kontak'] as $field) {
                    if (isset($m[$field]) && is_string($m[$field])) {
                        $m[$field] = trim($m[$field]);
                    }
                }
                $members[$i] = $m;
            }
            $this->merge(['members' => $members]);
        }
    }
}
