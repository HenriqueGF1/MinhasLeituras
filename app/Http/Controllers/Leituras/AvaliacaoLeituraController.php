<?php

namespace App\Http\Controllers\Leituras;

use App\Helpers\ApiResponse;

use App\Http\Controllers\Controller;
use App\Http\DTO\AvaliacaoLeitura\AvaliacaoLeituraCadastroDTO;
use App\Http\Requests\AvaliacaoLeitura\AvaliarLeituraCadastroRequest;
use App\Http\Resources\AvaliacaoLeitura\AvaliacaoLeituraResource;
use App\Http\Services\AvaliacaoLeitura\AvaliacaoLeituraCadastro;

class AvaliacaoLeituraController extends Controller
{
    public function __construct(protected AvaliacaoLeituraCadastro $avaliacaoLeituraCadastroService) {}

    public function __invoke(AvaliarLeituraCadastroRequest $request)
    {
        try {
            $dtoAvaliacaoLeituraCadastro = new AvaliacaoLeituraCadastroDTO($request->safe()->all());

            $avaliacaoLeitura = $this->avaliacaoLeituraCadastroService->cadastroDeAvaliacaoDeLeitura($dtoAvaliacaoLeituraCadastro);

            return ApiResponse::success(
                new AvaliacaoLeituraResource($avaliacaoLeitura),
                'Leitura Avaliada com sucesso'
            );
        } catch (\Throwable $exception) {
            return ApiResponse::fromException($exception);
        }
    }
}
