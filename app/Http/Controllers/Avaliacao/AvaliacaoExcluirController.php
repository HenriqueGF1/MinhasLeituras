<?php

namespace App\Http\Controllers\Avaliacao;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Services\AvaliacaoLeitura\AvaliacaoExcluir;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AvaliacaoExcluirController extends Controller
{
    public function __construct(
        protected AvaliacaoExcluir $serviceAvaliacaoExcluir
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        try {
            // $usuarioLeituraExcluirDTO = new UsuarioLeituraExcluirDTO($request->safe()->all());

            $this->serviceAvaliacaoExcluir->deletarAvaliacao($request->id_avaliacao_leitura);

            return ApiResponse::success(
                [],
                'Avaliação Leitura Excluida com sucesso'
            );
        } catch (\Throwable $exception) {
            return ApiResponse::fromException($exception);
        }
    }
}
