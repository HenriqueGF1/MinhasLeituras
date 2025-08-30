<?php

namespace App\Http\Controllers\Avaliacao;

use App\Http\Controllers\Controller;
use App\Http\Resources\AvaliacaoLeitura\AvaliacaoLeituraPesquisaResource;
use App\Http\Services\AvaliacaoLeitura\AvaliacaoPesquisa;

class AvaliacaoPesquisaController extends Controller
{
    public function __construct(
        protected AvaliacaoPesquisa $serviceAvaliacaoPesquisa
    ) {}

    public function __invoke()
    {
        return AvaliacaoLeituraPesquisaResource::collection(
            $this->serviceAvaliacaoPesquisa->pesquisa()
        );
    }
}
