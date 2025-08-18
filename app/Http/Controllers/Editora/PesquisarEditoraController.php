<?php

namespace App\Http\Controllers\Editora;

use App\Http\Controllers\Controller;
use App\Http\Services\Editora\EditorasPesquisa;

class PesquisarEditoraController extends Controller
{
    public function __construct(
        protected EditorasPesquisa $serviceAutoresPesquisa
    ) {}

    public function __invoke()
    {
        return $this->serviceAutoresPesquisa->listarEditoras();
    }
}
