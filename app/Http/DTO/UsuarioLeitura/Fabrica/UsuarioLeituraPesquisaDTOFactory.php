<?php

namespace App\Http\DTO\UsuarioLeitura\Fabrica;

use App\Http\DTO\Usuarioleitura\UsuarioLeituraPesquisaDTO;

class UsuarioLeituraPesquisaDTOFactory implements UsuarioLeituraDTOFactory
{
    public function criarDTO(array $dados): UsuarioLeituraPesquisaDTO
    {
        $dadosPesquisa = [
            'id_leitura' => isset($dados['id_leitura']) ? (int) $dados['id_leitura'] : null,
            'id_usuario' => isset($dados['id_usuario']) ? (int) $dados['id_usuario'] : null,
        ];

        return new UsuarioLeituraPesquisaDTO(
            $dadosPesquisa
        );
    }
}
