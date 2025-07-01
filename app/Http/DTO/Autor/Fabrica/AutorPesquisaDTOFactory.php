<?php

namespace App\Http\DTO\Autor\Fabrica;

use App\Http\DTO\Autor\AutorPesquisaDTO;

class AutorPesquisaDTOFactory implements AutorDTOFactory
{
    public function create(array $data): AutorPesquisaDTO
    {
        return new AutorPesquisaDTO($data);
    }
}
