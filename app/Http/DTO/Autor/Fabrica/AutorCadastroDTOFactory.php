<?php

namespace App\Http\DTO\Autor\Fabrica;

use App\Http\DTO\Autor\AutorCadastroDTO;

class AutorCadastroDTOFactory implements AutorDTOFactory
{
    public function criarDTO(array $dados): AutorCadastroDTO
    {
        $dadosCadastro = [
            'nome_autor' => (string) $dados['nome_autor'],
        ];

        return new AutorCadastroDTO(
            $dadosCadastro
        );
    }
}
