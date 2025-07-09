<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuarioLeituraExcluirRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'id_usuario_leitura' => $this->route('id_usuario_leitura'),
        ]);
    }

    public function rules(): array
    {
        return [
            'id_usuario_leitura' => [
                'required',
                'integer',
                'exists:usuario_leituras,id_usuario_leitura',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'id_usuario_leitura.required' => 'O campo ID do usuário leitura é obrigatório.',
            'id_usuario_leitura.integer' => 'O ID do usuário leitura deve ser um número inteiro.',
            'id_usuario_leitura.exists' => 'O ID do usuário leitura informado não existe na base de dados.',
        ];
    }
}
