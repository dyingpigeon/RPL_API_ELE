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
        return true; // jangan lupa true biar request diizinkan
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
                'dosen_id' => ['required', 'integer', 'exists:dosens,id'],
                'caption' => ['nullable', 'string'],
                'image_url' => ['nullable', 'string'],
            ];
        } else { // PATCH
            return [
                'dosen_id' => ['sometimes', 'integer', 'exists:dosens,id'],
                'caption' => ['sometimes', 'string'],
                'image_url' => ['sometimes', 'string'],
            ];
        }
    }
}
