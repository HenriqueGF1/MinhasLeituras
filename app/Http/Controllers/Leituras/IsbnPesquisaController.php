<?php

namespace App\Http\Controllers\Leituras;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Leitura\IsbnRequest;
use App\Http\Resources\Leitura\LeiturasResource;
use App\Http\Services\Leituras\IsbnPesquisa;

class IsbnPesquisaController extends Controller
{
    public function __construct(
        protected IsbnPesquisa $service
    ) {}

    /**
     * @OA\Get(
     *   path="/api/leituras/isbn/{isbn}",
     *   summary="Pesquisar Leitura pelo ISBN",
     *   description="Pesquisar Leituras pelo ISBN",
     *   tags={"Leituras"},
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
     *   @OA\Parameter(
     *      name="isbn",
     *      in="path",
     *      required=true,
     *      description="ISBN do livro a ser pesquisado",
     *
     *      @OA\Schema(type="string", example="")
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
    public function __invoke(IsbnRequest $request)
    {
        $leitura = $this->service->pesquisaIsbnBase($request->isbn);

        if (! is_null($leitura)) {
            return ApiResponse::success(
                new LeiturasResource(
                    $this->service->pesquisaIsbnBase($request->isbn)
                ),
                'Leitura',
                200
            );
        }

        return ApiResponse::success(
            [],
            'Leitura',
            200
        );
    }
}
