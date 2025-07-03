<?php

namespace App\Http\DTO\Editora\Fabrica;

use App\Http\DTO\Autor\Fabrica\AutorDTOFactory;
use App\Http\DTO\Editora\EditoraPesquisaDTO;

class EditoraPesquisaDTOFactory implements AutorDTOFactory
{
    public function criarDTO(array $dados): EditoraPesquisaDTO
    {
        $dadosPesquisa = [
            'id_editora' => (int) $dados['id_editora'],
            'descricao_editora' => (string) $dados['descricao_editora'],
        ];

        return new EditoraPesquisaDTO(
            $dadosPesquisa
        );
    }
}
