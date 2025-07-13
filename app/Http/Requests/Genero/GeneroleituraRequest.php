<?php

namespace App\Http\Requests\Genero;

use Illuminate\Foundation\Http\FormRequest;

class GeneroleituraRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $idLeitura = ['id_leitura' => 'nullable'];

        if (isset($this->id_editora)) {
            $idLeitura['id_leitura'] = 'required|exists:leituras,id_leitura';
        }

        return array_merge($idLeitura, [
            'id_genero' => 'required',
        ]);
    }

    public function messages(): array
    {
        return [
            'id_genero.required' => 'O campo gênero é obrigatório.',
            'id_genero.unique' => 'Este gênero já está vinculado a uma leitura.',
            'id_leitura.required' => 'O campo leitura é obrigatório.',
            'id_leitura.unique' => 'Esta leitura já está vinculada a um gênero.',
        ];
    }
}
