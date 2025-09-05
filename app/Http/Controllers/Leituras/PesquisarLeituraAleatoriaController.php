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

    /**
     * @OA\Get(
     *   path="/api/leituras/aleatoria",
     *   summary="Pesquisar Leitura Aleatória",
     *   description="Pesquisar Leitura Aleatória",
     *   tags={"Leituras"},
     *   security={{"bearerAuth":{}}},
     *
     *   @OA\Response(
     *     response=200,
     *     description="Pesquisar Leitura Aleatória",
     *
     *     @OA\JsonContent(
     *       type="object",
     *
     *       @OA\Property(property="success", type="boolean"),
     *       @OA\Property(property="message", type="string"),
     *       @OA\Property(property="data", type="object", description="Dados adicionais, se houver")
     *     )
     *   ),
     *
     *   @OA\Response(
     *     response=401,
     *     description="Não autorizado, token inválido ou ausente"
     *   ),
     *   @OA\Response(
     *     response=500,
     *     description="Erro interno no servidor"
     *   )
     * )
     */
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
