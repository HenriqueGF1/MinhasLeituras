<?php

namespace App\Http\Controllers\Avaliacao;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\DTO\AvaliacaoLeitura\AvaliacaoLeituraExcluirDTO;
use App\Http\Requests\AvaliacaoLeitura\AvaliarLeituraExcluirRequest;
use App\Http\Services\AvaliacaoLeitura\AvaliacaoExcluir;
use Illuminate\Http\JsonResponse;

class AvaliacaoExcluirController extends Controller
{
    public function __construct(
        protected AvaliacaoExcluir $serviceAvaliacaoExcluir
    ) {}

    public function __invoke(AvaliarLeituraExcluirRequest $request): JsonResponse
    {
        try {
            $avaliacaoLeituraExcluirDTO = new AvaliacaoLeituraExcluirDTO($request->safe()->all());

            $this->serviceAvaliacaoExcluir->deletarAvaliacao($avaliacaoLeituraExcluirDTO);

            return ApiResponse::success(
                [],
                'Avaliação Leitura Excluida com sucesso'
            );
        } catch (\Throwable $exception) {
            return ApiResponse::fromException($exception);
        }
    }
}
