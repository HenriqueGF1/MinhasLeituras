<?php

namespace App\Http\Requests\Autor;

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
            'nome' => 'nullable',
        ];
    }

    public function rulesNullableIdAutor(): array
    {
        return [
            'id_autor' => 'nullable',
            'nome_autor' => 'required|string|max:50',
        ];
    }

    public function messages(): array
    {
        return [
            'id_autor.required' => 'O campo id autor é obrigatório.',
            'id_autor.exists' => 'O autor selecionado é inválido.',

            'nome_autor.required' => 'O campo nome autor é obrigatório.',
            'nome_autor.string' => 'O nome deve ser um texto.',
            'nome_autor.max' => 'O nome não pode ter mais que 50 caracteres.',
        ];
    }
}
