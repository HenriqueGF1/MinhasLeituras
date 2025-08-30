<?php

namespace App\Http\Requests\AvaliacaoLeitura;

use Illuminate\Foundation\Http\FormRequest;

class AvaliarLeituraExcluirRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Para garantir que o parâmetro da rota
     * entre como "input" para as regras acima
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'id_avaliacao_leitura' => $this->route('id_avaliacao_leitura'),
        ]);
    }

    public function rules(): array
    {
        return [
            'id_avaliacao_leitura' => 'required|integer|exists:avaliacao_leitura,id_avaliacao_leitura',
        ];
    }

    public function messages(): array
    {
        return [
            'id_avaliacao_leitura.required' => 'O identificador da avaliação é obrigatório.',
            'id_avaliacao_leitura.integer' => 'O identificador da avaliação deve ser um número inteiro.',
            'id_avaliacao_leitura.exists' => 'A avaliação informada não foi encontrada no sistema.',
        ];
    }
}
