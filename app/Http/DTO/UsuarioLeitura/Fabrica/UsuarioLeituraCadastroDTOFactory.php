<?php

namespace App\Http\DTO\UsuarioLeitura\Fabrica;

use App\Http\DTO\UsuarioLeitura\UsuarioLeituraCadastroDTO;

class UsuarioLeituraCadastroDTOFactory implements UsuarioLeituraDTOFactory
{
    public function criarDTO(array $dados): UsuarioLeituraCadastroDTO
    {
        $dadosCadastro = [
            'id_leitura' => (int) $dados['id_leitura'],
            'id_usuario' => (int) $dados['id_usuario'],
            'id_status_leitura' => (int) $dados['id_status_leitura'],
        ];

        return new UsuarioLeituraCadastroDTO(
            $dadosCadastro
        );
    }
}
