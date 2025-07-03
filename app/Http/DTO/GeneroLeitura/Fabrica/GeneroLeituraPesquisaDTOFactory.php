<?php

namespace App\Http\DTO\GeneroLeitura\Fabrica;

use App\Http\DTO\GeneroLeitura\GeneroLeituraPesquisaDTO;

class GeneroLeituraPesquisaDTOFactory implements GeneroLeituraDTOFactory
{
    public function criarDTO(array $dados): GeneroLeituraPesquisaDTO
    {
        $dadosPesquisa = [
            'id_genero_leitura' => isset($dados['id_genero_leitura']) ? (int) $dados['id_genero_leitura'] : null,
            'id_genero' => isset($dados['id_genero']) ? (array) $dados['id_genero'] : null,
            'id_leitura' => isset($dados['id_leitura']) ? (int) $dados['id_leitura'] : null,
        ];

        // dd($dados, $dadosPesquisa);

        return new GeneroLeituraPesquisaDTO(
            $dadosPesquisa
        );
    }
}
