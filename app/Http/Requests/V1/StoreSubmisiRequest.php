<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubmisiRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'mahasiswaId' => ['required', 'integer', 'exists:mahasiswas,id'],
            'tugasId'     => ['required', 'integer', 'exists:tugas,id'],
            'fileUrl'     => ['required', 'string', 'max:255'],
            'komentar'    => ['nullable', 'string'],
            'selesai'     => ['boolean'],
            'nilai'       => ['nullable', 'integer', 'between:0,100'],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'mahasiswa_id' => $this->mahasiswaId,
            'tugas_id'     => $this->tugasId,
            'file_url'     => $this->fileUrl,
        ]);
    }
}
