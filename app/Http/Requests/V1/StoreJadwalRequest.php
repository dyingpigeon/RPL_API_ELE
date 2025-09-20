<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreJadwalRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'hari' => 'required|string',
            'jamMulai' => 'required|date_format:H:i',
            'jamSelesai' => 'required|date_format:H:i|after:jamMulai',
            'ruangan' => 'required|string',
            'dosenId' => 'required|integer|exists:dosens,id',
            'matkulId' => 'required|integer|exists:mata_kuliahs,id',
            'semester' => 'required|integer|min:1',
            'kelas' => 'required|string',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'jam_mulai' => $this->jamMulai,
            'jam_selesai' => $this->jamSelesai,
            'id_dosen' => $this->dosenId,
            'id_matkul' => $this->matkulId,
        ]);
    }
}
