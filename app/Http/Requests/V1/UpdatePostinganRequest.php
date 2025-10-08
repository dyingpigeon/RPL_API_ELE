<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostinganRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // pastikan true supaya request diizinkan
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
                'dosen_id' => ['required', 'integer', 'exists:dosens,id'],
                'jadwal_id' => ['required', 'integer', 'exists:jadwals,id'],
                'caption' => ['nullable', 'string'],
                'image_url' => ['nullable', 'string'],
            ];
        } else { // PATCH
            return [
                'dosen_id' => ['sometimes', 'integer', 'exists:dosens,id'],
                'jadwal_id' => ['sometimes', 'integer', 'exists:jadwals,id'],
                'caption' => ['sometimes', 'string'],
                'image_url' => ['sometimes', 'string'],
            ];
        }
    }

    /**
     * Ubah camelCase dari frontend menjadi snake_case untuk database.
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('dosenId')) {
            $this->merge(['dosen_id' => $this->dosenId]);
        }
        if ($this->has('jadwalId')) {
            $this->merge(['jadwal_id' => $this->jadwalId]);
        }
        if ($this->has('imageUrl')) {
            $this->merge(['image_url' => $this->imageUrl]);
        }
    }
}
