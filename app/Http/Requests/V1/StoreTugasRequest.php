<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreTugasRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'dosenId'   => ['required', 'integer', 'exists:dosens,id'],
            'jadwalId'  => ['required', 'integer', 'exists:jadwals,id'],
            'judul'     => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'fileUrl'   => ['nullable', 'string', 'max:255'],
            'deadline'  => ['nullable', 'date'],
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->has('dosenId')) {
            $this->merge(['dosen_id' => $this->dosenId]);
        }

        if ($this->has('jadwalId')) {
            $this->merge(['jadwal_id' => $this->jadwalId]);
        }

        if ($this->has('fileUrl')) {
            $this->merge(['file_url' => $this->fileUrl]);
        }
    }
}
