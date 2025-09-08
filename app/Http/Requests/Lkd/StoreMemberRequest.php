<?php

namespace App\Http\Requests\Lkd;

use Illuminate\Foundation\Http\FormRequest;

class StoreMemberRequest extends FormRequest
{
    public function authorize(): bool { return auth()->check(); }

    public function rules(): array {
        return [
            'nama'      => ['required','string','max:150'],
            'jabatan'   => ['nullable','string','max:150'],
            'kategori'  => ['nullable','string','max:100'],
            'kontak'    => ['nullable','string','max:100'],
            'order_no'  => ['nullable','integer','min:0'],
            'is_active' => ['nullable','boolean'],
            'foto'      => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
        ];
    }
}
