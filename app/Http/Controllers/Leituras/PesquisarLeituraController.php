<?php

namespace App\Http\Controllers\Leituras;

use App\Http\Controllers\Controller;
use App\Http\Resources\LeiturasResource;
use App\Http\Services\Leituras\LeiturasPesquisaService;
use Illuminate\Http\Request;

/**
 * @OA\PathItem(path="/api/leituras")
 */
class PesquisarLeituraController extends Controller
{
    public function __construct(
        protected LeiturasPesquisaService $service
    ) {}

    /*
    * Listar todas as leituras.
    *
    * @OA\Get(
    *     path="/api/leituras",
    *     summary="Retorna a lista de leituras",
    *     tags={"Leituras"},
    *
    *     @OA\Response(response=200, description="Lista de leituras")
    * )
    */
    public function __invoke(Request $request)
    {
        return LeiturasResource::collection(
            $this->service->pesquisa()
        );
    }
}
