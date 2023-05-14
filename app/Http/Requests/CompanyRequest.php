<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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
            'address' => 'required',
            'email' => 'nullable|email',
        ];
        return $array;
    }
    public function messages(): array
    {
        $array = [
            'name.required' => 'Nama perusahaan tidak boleh kosong',
            'address.required' => 'Alamat perusahaan tidak boleh kosong',
        ];
        return $array;
    }
}
