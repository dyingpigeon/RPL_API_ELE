<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // bisa ubah sesuai kebutuhan (misal hanya owner)
    }

    public function rules(): array
    {
        $method = $this->method();

        if ($method == 'PUT') {
            // PUT = update seluruh data
            return [
                'name' => ['required', 'string', 'max:255'],
            ];
        } else { // PATCH = update sebagian
            return [
                'name' => ['sometimes', 'string', 'max:255'],
            ];
        }
    }
}
