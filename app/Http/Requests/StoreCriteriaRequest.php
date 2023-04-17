<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCriteriaRequest extends FormRequest
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
            'name' => 'required',
            'criteria_type_id' => 'required',
            'parent_order' => 'required|numeric',
        ];
        if ($this->has('type_upload')) {
            $array['max_size'] = 'required|numeric|min:1|max:5';
            $array['format'] = 'boolean';
            $array['format_file'] = 'required_if:format,==,0';
            $array['max_files'] = 'required_if:type_upload,==,1|min:2|max:10';
            $array['type_upload'] = 'boolean';
        }
        if ($this->has('answer')) {
            $array['answer'] = 'required|array|min:2';
        }
        return $array;
    }
    public function messages(): array
    {
        $array = [
            'name.required' => 'Nama kriteria tidak boleh kosong',
            'criteria_type_id.required' => 'Tipe kriteria tidak boleh kosong',
            'parent_order.required' => 'Urutan kriteria tidak boleh kosong',
            'parent_order.numeric' => 'Urutan kriteria harus berupa angka',
        ];
        if ($this->has('answer')) {
            $array['answer.required'] = 'Jawaban tidak boleh kosong';
            $array['answer.size'] = 'Minimal Jawaban berjumlah 2';
        }
        if ($this->has('type_upload')) {
            $array['max_size.required'] = 'Maksimal Size per File tidak boleh kosong';
            $array['max_size.min'] = 'Maksimal Size per File minimal 1 MB';
            $array['max_size.max'] = 'Maksimal Size per File maksimal 5 MB';
            $array['max_size.numeric'] = 'Maksimal Size per File harus berupa angka';
            $array['format_file.required_if'] = 'Format File yang Diizinkan tidak boleh kosong';
            $array['max_files.required_if'] = 'Maksimal Jumlah File tidak boleh kosong';
            $array['max_files.min'] = 'Maksimal Jumlah File minimal 2 File';
            $array['max_files.max'] = 'Maksimal Jumlah File minimal 10 File';
        }
        return $array;
    }
}
