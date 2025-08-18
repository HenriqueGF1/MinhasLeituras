<?php

namespace App\Http\Controllers\Autor;

use App\Http\Controllers\Controller;
use App\Http\Services\Autor\AutoresPesquisa;

class PesquisarAutorController extends Controller
{
    public function __construct(
        protected AutoresPesquisa $serviceAutoresPesquisa
    ) {}

    public function __invoke()
    {
        return $this->serviceAutoresPesquisa->listarAutores();
    }
}
