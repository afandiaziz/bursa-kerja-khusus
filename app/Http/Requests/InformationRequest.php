<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InformationRequest extends FormRequest
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
            'title' => 'required',
            'content' => 'required',
        ];
        return $array;
    }
    public function messages(): array
    {
        $array = [
            'title.required' => 'Judul informasi tidak boleh kosong',
            'content.required' => 'Konten informasi tidak boleh kosong',
        ];
        return $array;
    }
}
