<?php

namespace App\Http\Controllers\Avaliacao;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\DTO\AvaliacaoLeitura\AvaliacaoLeituraExcluirDTO;
use App\Http\Requests\AvaliacaoLeitura\AvaliarLeituraExcluirRequest;
use App\Http\Services\AvaliacaoLeitura\AvaliacaoExcluir;
use Illuminate\Http\JsonResponse;

class AvaliacaoExcluirController extends Controller
{
    public function __construct(
        protected AvaliacaoExcluir $serviceAvaliacaoExcluir
    ) {}

    /**
     * @OA\Delete(
     *   path="/api/avaliacoes/{id_avaliacao_leitura}",
     *   summary="Excluir Avaliação Leitura do Usuário",
     *   description="Excluir Avaliação Leitura do Usuário",
     *   tags={"Avaliacao Leituras"},
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
     *   @OA\Parameter(
     *      name="id_avaliacao_leitura",
     *      in="path",
     *      required=true,
     *      description="Id Avaliacao Leitura da Avaliação",
     *
     *      @OA\Schema(type="integer")
     *   ),
     *
     *   @OA\Response(
     *     response=200,
     *     description="Leitura excluída com sucesso",
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
     *     response=404,
     *     description="Leitura não encontrada"
     *   ),
     *   @OA\Response(
     *     response=500,
     *     description="Erro interno no servidor"
     *   )
     * )
     */
    public function __invoke(AvaliarLeituraExcluirRequest $request): JsonResponse
    {
        try {
            $avaliacaoLeituraExcluirDTO = new AvaliacaoLeituraExcluirDTO($request->safe()->all());

            $this->serviceAvaliacaoExcluir->deletarAvaliacao($avaliacaoLeituraExcluirDTO);

            return ApiResponse::success(
                [],
                'Avaliação Leitura Excluida com sucesso'
            );
        } catch (\Throwable $exception) {
            return ApiResponse::fromException($exception);
        }
    }
}
