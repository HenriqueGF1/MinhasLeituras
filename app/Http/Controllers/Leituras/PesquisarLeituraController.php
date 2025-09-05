<?php

namespace App\Http\Controllers\Leituras;

use App\Http\Controllers\Controller;
use App\Http\Resources\Leitura\LeiturasResource;
use App\Http\Services\Leituras\LeiturasPesquisa;

/**
 * @OA\PathItem(path="/api/leituras")
 */
class PesquisarLeituraController extends Controller
{
    public function __construct(
        protected LeiturasPesquisa $service
    ) {}

    /**
     * @OA\Get(
     *   path="/api/leituras",
     *   summary="Pesquisar Leituras",
     *   description="Pesquisar Leituras",
     *   tags={"Leituras"},
     *   security={{"bearerAuth":{}}},
     *
     *   @OA\Response(
     *     response=200,
     *     description="Pesquisar Leituras",
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
        return LeiturasResource::collection(
            $this->service->pesquisa()
        );
    }
}
