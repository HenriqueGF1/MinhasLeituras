<?php

namespace App\Http\DTO\Leitura\Fabrica;

interface LeituraDTOFactory
{
    public function criarDTO(array $dados);
}
