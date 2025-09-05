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

    /**
     * @OA\Post(
     *   path="/api/progresso/total",
     *   summary="Pesquisa Leitura Progresso Total",
     *   description="Pesquisa Leitura Progresso Total",
     *   tags={"Progresso Leituras"},
     *   security={{"bearerAuth":{}}},
     *
     *   @OA\Parameter(
     *      name="token",
     *      in="query",
     *      required=true,
     *      description="Token de autenticação do usuário",
     *
     *      @OA\Schema(type="string")
     *   ),
     *
     *   @OA\RequestBody(
     *     required=true,
     *
     *     @OA\MediaType(
     *       mediaType="multipart/form-data",
     *
     *       @OA\Schema(
     *         type="object",
     *         required={"id_leitura"},
     *
     *         @OA\Property(property="id_leitura", type="integer", description="ID da leitura")
     *       )
     *     )
     *   ),
     *
     *   @OA\Response(
     *     response=200,
     *     description="Pesquisa Leitura Progresso Total realizada com sucesso",
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
