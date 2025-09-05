<?php

namespace App\Http\Controllers\Avaliacao;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\DTO\AvaliacaoLeitura\AvaliacaoLeituraCadastroDTO;
use App\Http\Requests\AvaliacaoLeitura\AvaliarLeituraCadastroRequest;
use App\Http\Resources\AvaliacaoLeitura\AvaliacaoLeituraResource;
use App\Http\Services\AvaliacaoLeitura\AvaliacaoLeituraCadastro;
use Illuminate\Http\JsonResponse;

class AvaliacaoLeituraCadastroController extends Controller
{
    public function __construct(protected AvaliacaoLeituraCadastro $avaliacaoLeituraCadastroService) {}

    /**
     * @OA\Post(
     *   path="/api/avaliacoes",
     *   summary="Cadastrar Avaliação da Leitura do Usuário",
     *   description="Cadastrar Avaliação de uma leitura feita pelo usuário",
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
     *   @OA\RequestBody(
     *     required=true,
     *
     *     @OA\MediaType(
     *       mediaType="multipart/form-data",
     *
     *       @OA\Schema(
     *         type="object",
     *         required={},
     *
     *         @OA\Property(property="id_leitura", type="integer", description="ID da leitura"),
     *         @OA\Property(property="nota", type="integer", description="Nota da avaliação"),
     *         @OA\Property(property="descricao_avaliacao", type="string", description="Descrição da avaliação"),
     *         @OA\Property(property="data_inicio", type="string", format="date", description="Data de início da leitura"),
     *         @OA\Property(property="data_termino", type="string", format="date", description="Data de término da leitura")
     *       )
     *     )
     *   ),
     *
     *   @OA\Response(
     *     response=201,
     *     description="Avaliação cadastrada com sucesso",
     *
     *     @OA\JsonContent(
     *       type="object",
     *
     *       @OA\Property(property="success", type="boolean"),
     *       @OA\Property(property="message", type="string"),
     *       @OA\Property(property="data", type="object", description="Dados da avaliação cadastrada")
     *     )
     *   ),
     *
     *   @OA\Response(
     *     response=400,
     *     description="Erro de validação nos campos enviados"
     *   ),
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
    public function __invoke(AvaliarLeituraCadastroRequest $request): JsonResponse
    {
        try {
            $dtoAvaliacaoLeituraCadastro = new AvaliacaoLeituraCadastroDTO($request->safe()->all());

            $avaliacaoLeitura = $this->avaliacaoLeituraCadastroService->cadastroDeAvaliacaoDeLeitura($dtoAvaliacaoLeituraCadastro);

            return ApiResponse::success(
                new AvaliacaoLeituraResource($avaliacaoLeitura),
                'Leitura Avaliada com sucesso',
                201
            );
        } catch (\Throwable $exception) {
            return ApiResponse::fromException($exception);
        }
    }
}
