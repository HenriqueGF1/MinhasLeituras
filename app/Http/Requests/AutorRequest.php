<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AutorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return false;
    }

    public function rules(): array
    {
        return [];
    }

    public function rulesRequiredIdAutor(): array
    {
        return [
            'id_autor' => 'required|exists:autor,id_autor',
            'nome' => 'string|max:50',
        ];
    }

    public function rulesNullableIdAutor(): array
    {
        return [
            'id_autor' => 'nullable',
            'nome' => 'string|max:50',
        ];
    }

    public function messages(): array
    {
        return [
            'id_autor.required' => 'O campo autor é obrigatório.',
            'id_autor.exists' => 'O autor selecionado é inválido.',
            'nome.string' => 'O nome deve ser um texto.',
            'nome.max' => 'O nome não pode ter mais que 50 caracteres.',
        ];
    }
}
