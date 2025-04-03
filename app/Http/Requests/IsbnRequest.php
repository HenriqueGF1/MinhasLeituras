<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IsbnRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'isbn' => preg_replace('/[^0-9Xx]/', '', $this->isbn), // Remove traços e mantém o "X" (para ISBN-10)
        ]);
    }

    public function rules()
    {
        return [
            'isbn' => ['required', 'regex:/^\d{9}[\dXx]$|^\d{13}$/'], // 10 dígitos (com "X") ou 13 dígitos numéricos
        ];
    }

    public function messages()
    {
        return [
            'isbn.required' => 'O campo ISBN é obrigatório.',
            'isbn.regex' => 'O ISBN deve ter 10 ou 13 caracteres numéricos, podendo terminar com X no caso do ISBN-10.',
        ];
    }
}
