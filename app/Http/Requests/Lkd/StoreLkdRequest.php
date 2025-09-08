<?php

namespace App\Http\Requests\Lkd;

use Illuminate\Foundation\Http\FormRequest;

class StoreLkdRequest extends FormRequest
{
    public function authorize(): bool { return auth()->check(); }

    public function rules(): array {
        return [
            'judul'      => ['required','string','max:200'],
            'deskripsi'  => ['nullable','string'],
            'published'  => ['nullable','boolean'],
            'cover'      => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
        ];
    }
}
