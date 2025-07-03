<?php

namespace App\Http\DTO\Leitura\Fabrica;

use App\Http\DTO\Leitura\LeituraPesquisaDTO;

class LeituraPesquisaDTOFactory implements LeituraDTOFactory
{
    public function criarDTO(array $dados): LeituraPesquisaDTO
    {
        $dadosPesquisa = [
            'id_leitura' => isset($dados['id_leitura']) ? (int) $dados['id_leitura'] : null,
            'titulo' => (string) $dados['titulo'],
        ];

        return new LeituraPesquisaDTO(
            $dadosPesquisa
        );
    }
}
