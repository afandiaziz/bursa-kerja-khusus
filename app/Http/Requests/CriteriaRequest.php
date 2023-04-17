<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CriteriaRequest extends FormRequest
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
            'min_length' => 'nullable|required_with:max_length|numeric|min:0',
            'max_length' => 'nullable|numeric|gte:min_length',
            'min_number' => 'nullable|required_with:max_number|numeric',
            'max_number' => 'nullable|numeric|gte:min_number',
        ];
        if ($this->has('type_upload')) {
            $array['max_size'] = 'required|numeric|min:0|max:5';
            $array['format'] = 'boolean';
            $array['format_file'] = 'required_if:format,==,0';
            $array['max_files'] = 'numeric|min:2|max:10|required_if:type_upload,==,1';
            $array['type_upload'] = 'boolean';
        }
        if ($this->has('answer')) {
            $array['answer'] = 'required|array|min:2';
            $array['answer.*'] = 'required';
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
            'min_length.numeric' => 'Minimum Panjang/Banyaknya Teks/Digits harus berupa angka',
            'max_length.numeric' => 'Maksimum Panjang/Banyaknya Teks/Digits harus berupa angka',
            'min_number.numeric' => 'Minimum Angka yang Diinput harus berupa angka',
            'max_number.numeric' => 'Maksimum Angka yang Diinput harus berupa angka',
            'min_length.min' => 'Minimum Panjang/Banyaknya Teks/Digits tidak boleh kurang dari 0',
            'min_number.min' => 'Minimum Angka yang Diinput tidak boleh kurang dari 0',
            'max_length.gte' => 'Maksimum Panjang/Banyaknya Teks/Digits tidak boleh kurang dari Minimum Panjang/Banyaknya Teks/Digits',
            'max_number.gte' => 'Maksimum Angka yang Diinput tidak boleh kurang dari Minimum Angka yang Diinput',
            'min_length.required_with' => 'Minimum Panjang/Banyaknya Teks/Digits tidak boleh kosong jika Maksimum Panjang/Banyaknya Teks/Digits diisi',
            'min_number.required_with' => 'Minimum Angka yang Diinput tidak boleh kosong jika Maksimum Angka yang Diinput diisi',
        ];
        if ($this->has('answer')) {
            $array['answer.required'] = 'Jawaban tidak boleh kosong';
            $array['answer.*.required'] = 'Jawaban tidak boleh kosong';
            $array['answer.size'] = 'Minimal Jawaban berjumlah 2';
        }
        if ($this->has('type_upload')) {
            $array['max_size.required'] = 'Maksimal Size per File tidak boleh kosong';
            $array['max_size.min'] = 'Maksimal Size per File minimal 0 MB';
            $array['max_size.max'] = 'Maksimal Size per File maksimal 5 MB';
            $array['max_size.numeric'] = 'Maksimal Size per File harus berupa angka';
            $array['format_file.required_if'] = 'Format File yang Diizinkan tidak boleh kosong';
            $array['max_files.min'] = 'Jumlah File harus berupa angka';
            $array['max_files.required_if'] = 'Maksimal Jumlah File tidak boleh kosong';
            $array['max_files.min'] = 'Minimal Jumlah File adalah minimal 2 File';
            $array['max_files.max'] = 'Maksimal Jumlah File adalah maksimal 10 File';
        }
        return $array;
    }
}
