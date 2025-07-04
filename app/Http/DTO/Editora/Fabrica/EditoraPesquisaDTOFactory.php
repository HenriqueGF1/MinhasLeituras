<?php

namespace App\Http\DTO\Editora\Fabrica;

use App\Http\DTO\Autor\Fabrica\AutorDTOFactory;
use App\Http\DTO\Editora\EditoraPesquisaDTO;

class EditoraPesquisaDTOFactory implements AutorDTOFactory
{
    public function criarDTO(array $dados): EditoraPesquisaDTO
    {
        return new EditoraPesquisaDTO(
            $dados
        );
    }
}
