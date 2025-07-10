<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LeituraProgressoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_usuario' => 'required|exists:usuario,id_usuario',
            'id_leitura' => 'required|integer|exists:leituras,id_leitura',
            'qtd_paginas_lidas' => 'required|integer|min:1',
            'data_leitura' => 'required|date|after_or_equal:today',
        ];
    }

    public function messages(): array
    {
        return [
            'id_usuario.required' => 'O campo usuário é obrigatório.',
            'id_usuario.exists' => 'O usuário informado não foi encontrado.',

            'id_leitura.required' => 'O campo leitura é obrigatório.',
            'id_leitura.integer' => 'O ID da leitura deve ser um número inteiro.',
            'id_leitura.exists' => 'A leitura informada não foi encontrada.',

            'qtd_paginas_lidas.required' => 'Informe a quantidade de páginas lidas.',
            'qtd_paginas_lidas.integer' => 'A quantidade de páginas lidas deve ser um número inteiro.',
            'qtd_paginas_lidas.min' => 'A quantidade de páginas lidas deve ser no mínimo 1.',

            'data_leitura.required' => 'A data da leitura é obrigatória.',
            'data_leitura.date' => 'Informe uma data válida para a leitura.',
            'data_leitura.after_or_equal' => 'A data da leitura deve ser hoje ou maior',
        ];
    }
}
