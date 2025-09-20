<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJadwalRequest extends FormRequest
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
        $method = $this->method();

        if ($method == 'PUT') {
            return [
                'hari' => ['required', 'string'],
                'jamMulai' => ['required', 'date_format:H:i'],
                'jamSelesai' => ['required', 'date_format:H:i', 'after:jamMulai'],
                'ruangan' => ['required', 'string'],
                'dosenId' => ['required', 'integer'],
                'matkulId' => ['required', 'integer'],
                'semester' => ['required', 'integer'],
                'kelas' => ['required', 'string'],
            ];
        } else {
            return [
                'hari' => ['required', 'string'],
                'jamMulai' => ['sometimes', 'date_format:H:i'],
                'jamSelesai' => ['sometimes', 'date_format:H:i', 'after:jamMulai'],
                'ruangan' => ['sometimes', 'string'],
                'dosenId' => ['sometimes', 'integer'],
                'matkulId' => ['sometimes', 'integer'],
                'semester' => ['sometimes', 'integer'],
                'kelas' => ['sometimes', 'string'],
            ];
        }
    }

protected function prepareForValidation()
{
    if ($this->has('jamMulai')) {
        $this->merge(['jam_mulai' => $this->jamMulai]);
    }
    if ($this->has('jamSelesai')) {
        $this->merge(['jam_selesai' => $this->jamSelesai]);
    }
    if ($this->has('dosenId')) {
        $this->merge(['id_dosen' => $this->dosenId]);
    }
    if ($this->has('matkulId')) {
        $this->merge(['id_matkul' => $this->matkulId]);
    }
}

}
