<?php

namespace App\Http\Controllers\Leituras;

use App\Http\Controllers\Controller;
use App\Http\Requests\Leitura\IsbnRequest;
use App\Http\Services\Api\Google\IsbnApiInterface;
use Illuminate\Http\JsonResponse;

class IsbnPesquisaApiController extends Controller
{
    public function __construct(protected IsbnApiInterface $pesquisaIsbApi) {}

    public function __invoke(IsbnRequest $request): JsonResponse
    {
        return $this->pesquisaIsbApi->procurarInformacaoLeituraPorIsbn($request->isbn);
    }
}
