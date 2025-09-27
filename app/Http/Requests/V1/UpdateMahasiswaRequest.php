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
            ];
        } else { // PATCH
            return [
                'nim' => ['sometimes', 'string'],
                'nama' => ['sometimes', 'string'],
            ];
        }
    }

    protected function prepareForValidation()
    {
        if ($this->nim) {
            // contoh NIM: 420221603123
            $diploma = substr($this->nim, 0, 1);         // 4 atau 3
            $tahunMasuk = substr($this->nim, 1, 4);      // 2021, 2022, dst
            $nomorProdi = substr($this->nim, 5, 2);      // 16, 35, 03

            // mapping nomor prodi ke nama prodi
            $mapProdi = [
                '35' => 'TRSE',
                '16' => 'TI',
                '03' => 'TL',
            ];
            $prodi = $mapProdi[$nomorProdi] ?? null;

            $this->merge([
                'diploma' => 'D' . $diploma,
                'tahun_masuk' => (int) $tahunMasuk,
                'nomor_prodi' => (int) $nomorProdi,
                'prodi' => $prodi,
            ]);
        }

        // sinkronkan penamaan agar sesuai DB
        $this->merge([
            'tahun_masuk' => $this->tahunMasuk ?? $this->tahun_masuk,
            'nomor_prodi' => $this->nomorProdi ?? $this->nomor_prodi,
        ]);
    }
}
