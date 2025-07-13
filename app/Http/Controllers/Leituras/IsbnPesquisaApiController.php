<?php

namespace App\Http\Controllers\Leituras;

use App\Http\Controllers\Controller;
use App\Http\Services\Api\Google\IsbnApiInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IsbnPesquisaApiController extends Controller
{
    public function __construct(protected IsbnApiInterface $googleBooks) {}

    public function __invoke(Request $request): JsonResponse
    {
        return $this->googleBooks->procurarInformacaoLeituraPorIsbn($request->isbn);
    }
}
