<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreTugasRequest extends FormRequest
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
            'dosenId'    => ['required', 'integer', 'exists:dosens,id'],
            'jadwalId'   => ['required', 'integer', 'exists:jadwals,id'],
            'judul'      => ['required', 'string', 'max:255'],
            'deskripsi'  => ['required', 'string'],
            'fileUrl'    => ['nullable', 'string', 'max:255'],
            'deadline'   => ['nullable', 'date'],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'dosen_id'   => $this->dosenId,
            'jadwal_id'  => $this->jadwalId,
            'file_url'   => $this->fileUrl,
        ]);
    }
}
