<?php

namespace App\Http\DTO\Autor\Strategy;

use App\Http\DTO\Autor\Fabrica\AutorCadastroDTOFactory;
use App\Http\DTO\Autor\Fabrica\AutorDTOFactory;
use App\Http\DTO\Autor\Fabrica\AutorPesquisaDTOFactory;

class AutorDTOStrategy
{
    public function getFactory(string $tipo): AutorDTOFactory
    {
        switch ($tipo) {
            case 'cadastro':
                return new AutorCadastroDTOFactory;
            case 'pesquisa':
                return new AutorPesquisaDTOFactory;
            default:
                throw new \InvalidArgumentException('Tipo de DTO desconhecido.');
        }
    }
}
