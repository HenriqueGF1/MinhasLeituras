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
