<?php

namespace App\Http\Controllers\ProgressoLeituras;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\DTO\LeituraProgresso\LeituraProgressoPesquisaDTO;
use App\Http\Requests\ProgressoLeitura\LeituraProgressoTotalPaginasRequest;
use App\Http\Resources\ProgressoLeitura\ProgressoLeituraTotalPaginasResource;
use App\Http\Services\Leituras\LeituraProgresso\LeituraProgressoTotalPaginasLida;

class PesquisarLeituraTotalPaginasLidasController extends Controller
{
    public function __construct(
        protected LeituraProgressoTotalPaginasLida $leituraProgressoTotalPaginasLidaService,
    ) {}

    public function __invoke(LeituraProgressoTotalPaginasRequest $request)
    {
        $dtoAvaliacaoLeituraPesquisa = new LeituraProgressoPesquisaDTO($request->safe()->all());

        $leituraProgresso = $this->leituraProgressoTotalPaginasLidaService->pesquisarLeituraProgressoTotalPaginasLida($dtoAvaliacaoLeituraPesquisa);

        return ApiResponse::success(
            new ProgressoLeituraTotalPaginasResource($leituraProgresso),
            'Progresso da Leitura',
            201
        );
    }
}
