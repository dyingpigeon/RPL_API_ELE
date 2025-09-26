<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTugasRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // harus true biar request diizinkan
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $method = $this->method();

        if ($method === 'PUT') {
            return [
                'dosen_id'   => ['required', 'integer', 'exists:dosens,id'],
                'jadwal_id'  => ['required', 'integer', 'exists:jadwals,id'],
                'judul'      => ['required', 'string', 'max:255'],
                'deskripsi'  => ['required', 'string'],
                'file_url'   => ['nullable', 'string', 'max:255'],
                'deadline'   => ['nullable', 'date'],
            ];
        } else { // PATCH
            return [
                'dosen_id'   => ['sometimes', 'integer', 'exists:dosens,id'],
                'jadwal_id'  => ['sometimes', 'integer', 'exists:jadwals,id'],
                'judul'      => ['sometimes', 'string', 'max:255'],
                'deskripsi'  => ['sometimes', 'string'],
                'file_url'   => ['sometimes', 'string', 'max:255'],
                'deadline'   => ['sometimes', 'date'],
            ];
        }
    }
}
