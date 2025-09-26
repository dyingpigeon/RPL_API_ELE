<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMahasiswaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $method = $this->method();

        if ($method == 'PUT') {
            return [
                'nim' => ['required', 'string'],
                'nama' => ['required', 'string'],
                'prodi' => ['required', 'string', 'in:TI,TRSE,TL'],
                'diploma' => ['required', 'string', 'in:D3,D4'],
                'tahunMasuk' => ['required', 'integer', 'min:2021', 'max:' . date('Y')],
                'nomorProdi' => ['required', 'integer'],
            ];
        } else { // PATCH
            return [
                'nim' => ['sometimes', 'string'],
                'nama' => ['sometimes', 'string'],
                'prodi' => ['sometimes', 'string', 'in:TI,TRSE,TL'],
                'diploma' => ['sometimes', 'string', 'in:D3,D4'],
                'tahunMasuk' => ['sometimes', 'integer', 'min:2021', 'max:' . date('Y')],
                'nomorProdi' => ['sometimes', 'integer'],
            ];
        }
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'tahun_masuk' => $this->tahunMasuk,
            'nomor_prodi' => $this->nomorProdi,
        ]);
    }
}
