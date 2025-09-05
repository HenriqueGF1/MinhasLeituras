<?php

namespace App\Http\Controllers\Editora;

use App\Http\Controllers\Controller;
use App\Http\Resources\Editoras\EditorasResource;
use App\Http\Services\Editora\EditorasPesquisa;

class PesquisarEditoraController extends Controller
{
    public function __construct(
        protected EditorasPesquisa $serviceAutoresPesquisa
    ) {}

    /**
     * @OA\Get(
     *   path="/api/editoras",
     *   summary="Pesquisar Editoras da Leitura",
     *   description="Pesquisar Editoras da Leitura",
     *   tags={"Editoras Leituras"},
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
     *     description="Pesquisar Editoras da Leitura",
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
        return EditorasResource::collection(
            $this->serviceAutoresPesquisa->listarEditoras()
        );
    }
}
