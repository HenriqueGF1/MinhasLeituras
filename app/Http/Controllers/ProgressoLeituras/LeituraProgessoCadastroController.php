<?php

namespace App\Http\Controllers\ProgressoLeituras;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProgressoLeitura\LeituraProgressoCadastroRequest;
use App\Http\Services\Leituras\LeituraProgresso\LeituraProgressoCadastramento;
use Illuminate\Http\JsonResponse;

class LeituraProgessoCadastroController extends Controller
{
    public function __construct(
        protected LeituraProgressoCadastramento $leituraProgressoCadastramentoService,
    ) {}

    /**
     * @OA\Post(
     *   path="/api/progresso",
     *   summary="Cadastro Leitura Progresso",
     *   description="Cadastro Leitura Progresso",
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
     *         required={"data_leitura","id_leitura","qtd_paginas_lidas"},
     *
     *         @OA\Property(
     *           property="data_leitura",
     *           type="string",
     *           format="date-time",
     *           description="Data e hora da leitura no formato ISO 8601 (ex: 2025-09-01T14:06)",
     *           example="2025-09-01T14:06"
     *         ),
     *         @OA\Property(
     *           property="id_leitura",
     *           type="integer",
     *           description="ID da leitura"
     *         ),
     *         @OA\Property(
     *           property="qtd_paginas_lidas",
     *           type="integer",
     *           description="Quantidade de páginas lidas na leitura"
     *         )
     *       )
     *     )
     *   ),
     *
     *   @OA\Response(
     *     response=200,
     *     description="Cadastro Leitura Progresso realizado com sucesso",
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
    public function __invoke(LeituraProgressoCadastroRequest $request): JsonResponse
    {
        return $this->leituraProgressoCadastramentoService->cadastramentoLeituraProgesso($request);
    }
}
