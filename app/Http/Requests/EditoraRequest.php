<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditoraRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        $idEditora = ['id_editora' => 'nullable'];

        if (isset($this->id_editora)) {
            $idEditora['id_editora'] = '"required|exists:editora,id_editora';
        }

        return array_merge($idEditora, [
            'descricao_editora' => 'string|max:50',
        ]);
    }

    public function messages(): array
    {
        return [
            'id_editora.required' => 'O campo editora é obrigatório.',
            'id_editora.exists' => 'A editora selecionada é inválida.',
            'descricao_editora.string' => 'A descrição da editora deve ser um texto.',
            'descricao_editora.max' => 'A descrição da editora não pode ter mais que 50 caracteres.',
        ];
    }
}
