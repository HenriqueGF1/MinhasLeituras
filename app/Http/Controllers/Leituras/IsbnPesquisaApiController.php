<?php

namespace App\Http\Controllers\Leituras;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Leitura\IsbnRequest;
use App\Http\Services\Api\Google\IsbnApiInterface;
use Illuminate\Http\JsonResponse;

class IsbnPesquisaApiController extends Controller
{
    public function __construct(protected IsbnApiInterface $pesquisaIsbApi) {}

    /**
     * @OA\Get(
     *   path="/api/leituras/isbn-api/{isbn}",
     *   summary="Pesquisar Leitura pelo ISBN em API externa",
     *   description="Pesquisar Leituras pelo ISBN em API externa",
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
    public function __invoke(IsbnRequest $request): JsonResponse
    {
        $leitura = $this->pesquisaIsbApi->procurarInformacaoLeituraPorIsbn($request->isbn);

        if (! is_null($leitura)) {
            return ApiResponse::success(
                $leitura,
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
