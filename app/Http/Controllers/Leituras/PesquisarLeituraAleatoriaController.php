<?php

namespace App\Http\Controllers\Leituras;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Leitura\LeiturasResource;
use App\Http\Services\Leituras\LeituraPesquisaAleatoria;

class PesquisarLeituraAleatoriaController extends Controller
{
    public function __construct(
        protected LeituraPesquisaAleatoria $leituraPesquisaAleatoriaService
    ) {}

    public function __invoke()
    {
        return ApiResponse::success(
            new LeiturasResource(
                $this->leituraPesquisaAleatoriaService->pesquisaLeituraAleatoria()
            ),
            'Leitura Aleatoria',
            201
        );
    }
}
