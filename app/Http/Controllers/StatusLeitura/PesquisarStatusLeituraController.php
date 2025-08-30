<?php

namespace App\Http\Controllers\StatusLeitura;

use App\Http\Controllers\Controller;
use App\Http\Resources\StatusLeitura\StatusLeituraResource;
use App\Http\Services\StatusLeitura\StatusLeiturasPesquisa;

class PesquisarStatusLeituraController extends Controller
{
    public function __construct(
        protected StatusLeiturasPesquisa $serviceStatusLeiturasPesquisa
    ) {}

    public function __invoke()
    {
        return StatusLeituraResource::collection(
            $this->serviceStatusLeiturasPesquisa->listarStatusLeitura()
        );
    }
}
