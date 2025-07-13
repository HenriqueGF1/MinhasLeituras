<?php

namespace App\Http\Requests\Editora;

use Illuminate\Foundation\Http\FormRequest;

class EditoraRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules($dados)
    {
        return [];
    }

    public function rulesRequiredIdEditora(): array
    {
        return [
            'id_editora' => 'required|exists:editora,id_editora',
            'descricao_editora' => 'nullable|string|max:50',
        ];
    }

    public function rulesNullableIdEditora(): array
    {
        return [
            'id_editora' => 'nullable',
            'descricao_editora' => 'nullable|string|max:50',
        ];
    }

    public function messages(): array
    {
        return [
            'id_editora.required' => 'O campo editora é obrigatório.',
            'id_editora.exists' => 'A editora informada não foi encontrada.',

            'descricao_editora.string' => 'A descrição da editora deve ser um texto.',
            'descricao_editora.max' => 'A descrição da editora não pode ter mais que 50 caracteres.',
        ];
    }
}
