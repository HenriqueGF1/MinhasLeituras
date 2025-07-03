<?php

namespace App\Http\DTO\Editora\Fabrica;

use App\Http\DTO\Autor\Fabrica\AutorDTOFactory;
use App\Http\DTO\Editora\EditoraCadastroDTO;

class EditoraCadastroDTOFactory implements AutorDTOFactory
{
    public function criarDTO(array $dados): EditoraCadastroDTO
    {
        $dadosCadastro = [
            'descricao_editora' => (string) $dados['descricao_editora'],
        ];

        return new EditoraCadastroDTO(
            $dadosCadastro
        );
    }
}
