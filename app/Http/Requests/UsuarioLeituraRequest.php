<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuarioLeituraRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        $idLeitura = ['id_leitura' => 'nullable'];

        if (isset($this->id_leitura)) {
            $idLeitura['id_leitura'] = 'required|exists:leituras,id_leitura';
        }

        return array_merge($idLeitura, [
            'id_usuario' => 'required|exists:usuario,id_usuario',
            'id_status_leitura' => 'required|exists:status_leitura,id_status_leitura',
        ]);
    }

    public function messages()
    {
        return
            [
                'id_usuario.required' => 'O campo ID do usuário é obrigatório.',
                'id_usuario.exists' => 'O ID do usuário informado não existe.',
                'id_leitura.required' => 'O campo leitura é obrigatório.',
                'id_leitura.exists' => 'O ID da leitura informado não existe.',
                'id_status_leitura.required' => 'O campo status da leitura é obrigatório.',
                'id_status_leitura.exists' => 'O ID do status da leitura informado não existe.',
            ];
    }
}
