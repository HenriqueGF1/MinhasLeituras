<?php

namespace App\Http\DTO\Autor\Fabrica;

use App\Http\DTO\Autor\AutorCadastroDTO;

class AutorCadastroDTOFactory implements AutorDTOFactory
{
    public function create(array $data): AutorCadastroDTO
    {
        return new AutorCadastroDTO($data['nome_autor']);
    }
}
