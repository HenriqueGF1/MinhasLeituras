<?php

namespace App\Http\Controllers\Leituras;

use App\Http\Controllers\Controller;
use App\Http\DTO\LeituraProgresso\LeituraProgressoPesquisaDTO;
use App\Http\Services\Leituras\LeituraProgresso\LeituraProgressoTotalPaginasLida;
use Illuminate\Http\Request;

class PesquisarLeituraTotalPaginasLidasController extends Controller
{
    public function __construct(
        protected LeituraProgressoTotalPaginasLida $leituraProgressoTotalPaginasLidaService,
    ) {}

    public function __invoke(Request $request)
    {
        $dtoAvaliacaoLeituraPesquisa = new LeituraProgressoPesquisaDTO($request->all());

        return $this->leituraProgressoTotalPaginasLidaService->pesquisarLeituraProgressoTotalPaginasLida($dtoAvaliacaoLeituraPesquisa);
    }
}
