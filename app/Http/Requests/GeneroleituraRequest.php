<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GeneroleituraRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // 'id_genero' => 'required|unique:genero_leitura,id_genero',
            // 'id_leitura' => 'required|unique:leituras,id_leitura',
        ];
    }

    public function messages(): array
    {
        return [
            'id_genero.required' => 'O campo gênero é obrigatório.',
            // 'id_genero.unique' => 'Este gênero já está vinculado a uma leitura.',
            // 'id_leitura.required' => 'O campo leitura é obrigatório.',
            // 'id_leitura.unique' => 'Esta leitura já está vinculada a um gênero.',
        ];
    }
}
