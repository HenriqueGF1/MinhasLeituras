<?php

namespace App\Http\Controllers\Avaliacao;

use App\Http\Controllers\Controller;
use App\Http\Resources\AvaliacaoLeitura\AvaliacaoLeituraPesquisaResource;
use App\Http\Services\AvaliacaoLeitura\AvaliacaoPesquisa;

class AvaliacaoPesquisaController extends Controller
{
    public function __construct(
        protected AvaliacaoPesquisa $serviceAvaliacaoPesquisa
    ) {}

    /**
     * @OA\Get(
     *   path="/api/avaliacoes",
     *   summary="Pesquisar Avaliação Leitura do Usuário",
     *   description="Pesquisar Avaliação Leitura do Usuário",
     *   tags={"Avaliacao Leituras"},
     *   security={{"bearerAuth":{}}},
     *
     *   @OA\Parameter(
     *      name="token",
     *                                         in="query",
     *      required=true,
     *      description="Token de autenticação do usuário",
     *
     *      @OA\Schema(type="string")
     *   ),
     *
     *   @OA\Response(
     *     response=200,
     *     description="Pesquisar Leituras com sucesso",
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
        return AvaliacaoLeituraPesquisaResource::collection(
            $this->serviceAvaliacaoPesquisa->pesquisa()
        );
    }
}
