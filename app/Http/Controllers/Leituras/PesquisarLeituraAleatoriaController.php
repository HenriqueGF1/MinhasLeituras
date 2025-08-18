<?php

namespace App\Http\Controllers\Leituras;

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
        return new LeiturasResource(
            $this->leituraPesquisaAleatoriaService->pesquisaLeituraAleatoria()
        );
    }
}
