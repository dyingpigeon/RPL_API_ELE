<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSubmisiRequest extends FormRequest
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
                'mahasiswa_id' => ['required', 'integer', 'exists:mahasiswas,id'],
                'tugas_id'     => ['required', 'integer', 'exists:tugas,id'],
                'file_url'     => ['required', 'string', 'max:255'],
                'komentar'     => ['nullable', 'string'],
                'selesai'      => ['required', 'boolean'],
                'nilai'        => ['nullable', 'integer', 'between:0,100'],
            ];
        } else { // PATCH
            return [
                'mahasiswa_id' => ['sometimes', 'integer', 'exists:mahasiswas,id'],
                'tugas_id'     => ['sometimes', 'integer', 'exists:tugas,id'],
                'file_url'     => ['sometimes', 'string', 'max:255'],
                'komentar'     => ['sometimes', 'string'],
                'selesai'      => ['sometimes', 'boolean'],
                'nilai'        => ['sometimes', 'integer', 'between:0,100'],
            ];
        }
    }
}
