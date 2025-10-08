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
        return true; // harus true agar request diizinkan
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $method = $this->method();

        if ($method == 'PUT') {
            return [
                'dosenId'   => ['required', 'integer'],
                'jadwalId'  => ['required', 'integer'],
                'judul'     => ['required', 'string', 'max:255'],
                'deskripsi' => ['required', 'string'],
                'fileUrl'   => ['nullable', 'string', 'max:255'],
                'deadline'  => ['nullable', 'date'],
            ];
        } else {
            return [
                'dosenId'   => ['sometimes', 'integer'],
                'jadwalId'  => ['sometimes', 'integer'],
                'judul'     => ['sometimes', 'string', 'max:255'],
                'deskripsi' => ['sometimes', 'string'],
                'fileUrl'   => ['sometimes', 'string', 'max:255'],
                'deadline'  => ['sometimes', 'date'],
            ];
        }
    }

    /**
     * Map input field dari camelCase ke snake_case agar sesuai dengan kolom database.
     */
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
