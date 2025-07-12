<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AvaliarLeituraCadastroRequest extends FormRequest
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
            'nota' => 'required|integer|between:0,10',
            'descricao_avaliacao' => 'required|string|min:10',
            'data_inicio' => 'required|date',
            'data_termino' => 'required|date|after_or_equal:data_inicio',
        ];
    }

    public function messages(): array
    {
        return [
            'id_usuario.required' => 'O campo usuário é obrigatório.',
            'id_usuario.exists' => 'O usuário selecionado não existe.',

            'id_leitura.required' => 'O campo leitura é obrigatório.',
            'id_leitura.integer' => 'O campo leitura deve ser um número inteiro.',
            'id_leitura.exists' => 'A leitura selecionada não existe.',

            'nota.required' => 'A nota é obrigatória.',
            'nota.integer' => 'A nota deve ser um número inteiro.',
            'nota.between' => 'A nota deve estar entre 0 e 10.',

            'descricao_avaliacao.required' => 'A descrição da avaliação é obrigatória.',
            'descricao_avaliacao.string' => 'A descrição da avaliação deve ser um texto.',
            'descricao_avaliacao.min' => 'A descrição da avaliação deve ter pelo menos 10 caracteres.',

            'data_inicio.required' => 'A data de início é obrigatória.',
            'data_inicio.date' => 'A data de início deve ser uma data válida.',

            'data_termino.required' => 'A data de término é obrigatória.',
            'data_termino.date' => 'A data de término deve ser uma data válida.',
            'data_termino.after_or_equal' => 'A data de término deve ser igual ou posterior à data de início.',
        ];
    }
}
