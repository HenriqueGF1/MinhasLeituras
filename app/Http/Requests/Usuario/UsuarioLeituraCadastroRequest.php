<?php

namespace App\Http\Requests\Usuario;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UsuarioLeituraCadastroRequest extends FormRequest
{
    /**
     * Determine se o usuário está autorizado a fazer esta requisição.
     */
    public function authorize(): bool
    {
        return true; // Ajuste se houver regras de autorização específicas
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'id_usuario' => Auth::user()->id_usuario,
        ]);
    }

    /**
     * Regras de validação.
     */
    public function rules(): array
    {
        return [
            'id_leitura' => 'required|integer|exists:leituras,id_leitura',
            'id_usuario' => 'required|integer|exists:usuario,id_usuario',
            'id_status_leitura' => 'required|integer|exists:status_leitura,id_status_leitura',
        ];
    }

    /**
     * Mensagens de erro personalizadas.
     */
    public function messages(): array
    {
        return [
            'id_leitura.required' => 'O campo leitura é obrigatório.',
            'id_leitura.integer' => 'O campo leitura deve ser um número inteiro.',
            'id_leitura.exists' => 'A leitura informada não existe.',

            'id_usuario.required' => 'O campo usuário é obrigatório.',
            'id_usuario.integer' => 'O campo usuário deve ser um número inteiro.',
            'id_usuario.exists' => 'O usuário informado não existe.',

            'id_status_leitura.required' => 'O campo status de leitura é obrigatório.',
            'id_status_leitura.integer' => 'O campo status de leitura deve ser um número inteiro.',
            'id_status_leitura.exists' => 'O status de leitura informado não existe.',
        ];
    }
}
