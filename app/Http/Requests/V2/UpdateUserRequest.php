<?php
// app/Http\Requests\V2\UpdateUserRequest.php

namespace App\Http\Requests\V2;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        if ($this->isMethod('put')) {
            return [
                'name' => ['required', 'string', 'max:255'],
                'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            ];
        }

        return [
            'name' => ['sometimes', 'string', 'max:255'],
            'photo' => ['sometimes', 'nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ];
    }


    public function messages(): array
    {
        return [
            'photo.image' => 'File harus berupa gambar',
            'photo.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif',
            'photo.max' => 'Ukuran gambar maksimal 2MB',
        ];
    }
}