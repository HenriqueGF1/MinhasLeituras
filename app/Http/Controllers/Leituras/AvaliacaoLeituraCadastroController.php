<?php

namespace App\Http\Controllers\Leituras;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\DTO\AvaliacaoLeitura\AvaliacaoLeituraCadastroDTO;
use App\Http\Requests\AvaliacaoLeitura\AvaliarLeituraCadastroRequest;
use App\Http\Resources\AvaliacaoLeitura\AvaliacaoLeituraResource;
use App\Http\Services\AvaliacaoLeitura\AvaliacaoLeituraCadastro;
use Illuminate\Http\JsonResponse;

class AvaliacaoLeituraCadastroController extends Controller
{
    public function __construct(protected AvaliacaoLeituraCadastro $avaliacaoLeituraCadastroService) {}

    public function __invoke(AvaliarLeituraCadastroRequest $request): JsonResponse
    {
        try {
            $dtoAvaliacaoLeituraCadastro = new AvaliacaoLeituraCadastroDTO($request->safe()->all());

            $avaliacaoLeitura = $this->avaliacaoLeituraCadastroService->cadastroDeAvaliacaoDeLeitura($dtoAvaliacaoLeituraCadastro);

            return ApiResponse::success(
                new AvaliacaoLeituraResource($avaliacaoLeitura),
                'Leitura Avaliada com sucesso',
                201
            );
        } catch (\Throwable $exception) {
            return ApiResponse::fromException($exception);
        }
    }
}
