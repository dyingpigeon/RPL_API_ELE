<?php
namespace App\Http\Requests\V2;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        Log::info('=== PREPARE FOR VALIDATION ===');
        Log::info('Request Method: ' . $this->method());
        Log::info('Content-Type: ' . $this->header('Content-Type'));
        
        // Debug input
        $allData = $this->all();
        Log::info('Input Keys: ' . implode(', ', array_keys($allData)));
    }

    public function rules(): array
    {
        Log::info('=== APPLYING VALIDATION RULES ===');
        
        return [];
        // ✅ KEMBALIKAN RULES YANG BENAR
        if ($this->isMethod('put') || $this->isMethod('post')) {
            return [
                'name' => ['required', 'string', 'max:255'],
                'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            ];
        }

        return [
            'name' => ['sometimes', 'string', 'max:255'],
            'photo' => ['sometimes', 'nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama harus diisi',
            'name.string' => 'Nama harus berupa teks',
            'name.max' => 'Nama maksimal 255 karakter',
            'photo.image' => 'File harus berupa gambar',
            'photo.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif',
            'photo.max' => 'Ukuran gambar maksimal 2MB',
        ];
    }
}