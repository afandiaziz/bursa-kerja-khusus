<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VacancyRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $array = [
            'company_id' => 'required',
            'position' => 'required',
            'criteria' => 'required|array|min:1',
            'deadline' => 'required|date',
            'description' => 'required',
            'information' => 'nullable',
            'max_applicants' => 'nullable|numeric|min:1',
        ];
        return $array;
    }
    public function messages(): array
    {
        $array = [
            'company_id.required' => 'Perusahaan tidak boleh kosong',
            'position.required' => 'Posisi lowongan pekerjaan tidak boleh kosong',
            'description.required' => 'Deskripsi lowongan pekerjaan tidak boleh kosong',
            'criteria.required' => 'Kriteria lowongan pekerjaan tidak boleh kosong',
            'criteria.min' => 'Kriteria lowongan pekerjaan tidak boleh kosong',
            'deadline.date' => 'Batas tanggal pendaftaran harus berupa tanggal',
            'deadline.required' => 'Batas tanggal pendaftaran tidak boleh kosong',
            'max_applicants.numeric' => 'Batas total pelamar harus berupa angka',
            'max_applicants.min' => 'Batas total pelamar minimal 1',
        ];
        return $array;
    }
}
