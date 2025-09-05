<?php

namespace App\Http\Controllers\Generos;

use App\Http\Controllers\Controller;
use App\Http\Resources\Generos\GenerosResource;
use App\Http\Services\Genero\GenerosPesquisa;

class PesquisarGenerosController extends Controller
{
    public function __construct(
        protected GenerosPesquisa $serviceGenerosPesquisa
    ) {}

    /**
     * @OA\Get(
     *   path="/api/generos",
     *   summary="Pesquisar Generos da Leitura",
     *   description="Pesquisar Generos da Leitura",
     *   tags={"Generos Leituras"},
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
     *     description="Pesquisar Generos da Leitura",
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
        return GenerosResource::collection(
            $this->serviceGenerosPesquisa->listarGenerosLeitura()
        );
    }
}
