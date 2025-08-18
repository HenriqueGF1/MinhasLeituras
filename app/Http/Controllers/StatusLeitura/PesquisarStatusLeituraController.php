<?php

namespace App\Http\Controllers\StatusLeitura;

use App\Http\Controllers\Controller;
use App\Http\Services\StatusLeitura\StatusLeiturasPesquisa;

class PesquisarStatusLeituraController extends Controller
{
    public function __construct(
        protected StatusLeiturasPesquisa $serviceStatusLeiturasPesquisa
    ) {}

    public function __invoke()
    {
        return $this->serviceStatusLeiturasPesquisa->listarStatusLeitura();
    }
}
