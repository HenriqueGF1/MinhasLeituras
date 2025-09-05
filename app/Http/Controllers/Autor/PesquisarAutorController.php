<?php

namespace App\Http\Controllers\Autor;

use App\Http\Controllers\Controller;
use App\Http\Resources\Autores\AutoresResource;
use App\Http\Services\Autor\AutoresPesquisa;

class PesquisarAutorController extends Controller
{
    public function __construct(
        protected AutoresPesquisa $serviceAutoresPesquisa
    ) {}

    /**
     * @OA\Get(
     *   path="/api/autores",
     *   summary="Pesquisar Autores da Leitura",
     *   description="Pesquisar Autores da Leitura",
     *   tags={"Autores Leituras"},
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
     *     description="Pesquisar Autores da Leitura",
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
        return AutoresResource::collection(
            $this->serviceAutoresPesquisa->listarAutores()
        );
    }
}
