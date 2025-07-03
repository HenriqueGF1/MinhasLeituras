<?php

namespace App\Http\DTO\Autor\Fabrica;

use App\Http\DTO\Autor\AutorPesquisaDTO;

class AutorPesquisaDTOFactory implements AutorDTOFactory
{
    public function criarDTO(array $dados): AutorPesquisaDTO
    {
        $dadosPesquisa = [
            'id_autor' => (int) isset($dados['id_autor']) ? $dados['id_autor'] : null,
            'nome_autor' => (string) isset($dados['nome_autor']) ? $dados['nome_autor'] : null,
        ];

        return new AutorPesquisaDTO(
            $dadosPesquisa
        );
    }
}
