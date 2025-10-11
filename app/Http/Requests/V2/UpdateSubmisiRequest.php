<?php

namespace App\Http\Requests\V2;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSubmisiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        if ($this->isMethod('put')) {
            return [
                'mahasiswa_id' => ['sometimes', 'integer', 'exists:mahasiswas,id'],
                'tugas_id'     => ['sometimes', 'integer', 'exists:tugas,id'],
                'fileUrl'      => ['required', 'file', 'mimes:pdf,doc,docx,zip,rar,txt,jpg,jpeg,png', 'max:10240'],
                'komentar'     => ['nullable', 'string'],
                'selesai'      => ['sometimes', 'boolean'],
                'nilai'        => ['nullable', 'integer', 'between:0,100'],
            ];
        }

        return [
            'mahasiswa_id' => ['sometimes', 'integer', 'exists:mahasiswas,id'],
            'tugas_id'     => ['sometimes', 'integer', 'exists:tugas,id'],
            'fileUrl'      => ['sometimes', 'nullable', 'file', 'mimes:pdf,doc,docx,zip,rar,txt,jpg,jpeg,png', 'max:10240'],
            'komentar'     => ['sometimes', 'nullable', 'string'],
            'selesai'      => ['sometimes', 'boolean'],
            'nilai'        => ['sometimes', 'nullable', 'integer', 'between:0,100'],
        ];
    }

    public function messages(): array
    {
        return [
            'fileUrl.file' => 'File harus berupa file yang valid',
            'fileUrl.mimes' => 'Format file harus: pdf, doc, docx, zip, rar, txt, jpg, jpeg, png',
            'fileUrl.max' => 'Ukuran file maksimal 10MB',
        ];
    }
}