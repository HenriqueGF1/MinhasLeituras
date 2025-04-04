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
}
