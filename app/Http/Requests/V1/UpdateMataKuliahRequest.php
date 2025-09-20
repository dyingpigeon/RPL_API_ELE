<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class UpdateMataKuliahRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        $method = $this->method();

        if ($method == 'PUT') {
            return [
                'mataKuliah' => ['required', 'string'],
                'sks' => ['required', 'integer'],
            ];
        } else {
            return [
                'mataKuliah' => ['sometimes'],
                'sks' => ['sometimes'],
            ];
        }
    }

    protected function prepareForValidation()
    {
        // Hanya merge jika field ada di request
        if ($this->has('mataKuliah')) {
            $this->merge([
                'mata_kuliah' => $this->mataKuliah
            ]);
        }

        // Jika hanya sks yang di-update, jangan merge mata_kuliah
    }
}
