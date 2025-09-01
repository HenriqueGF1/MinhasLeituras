<?php

namespace App\Http\Requests\ProgressoLeitura;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class LeituraProgressoTotalPaginasRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'id_usuario' => Auth::user()->id_usuario,
        ]);
    }

    public function rules(): array
    {
        return [
            'id_usuario' => 'required|exists:usuario,id_usuario',
            'id_leitura' => 'required|integer|exists:leituras,id_leitura',
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
        ];
    }
}
