<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\DTO\UsuarioLeitura\UsuarioLeituraExcluirDTO;
use App\Http\Requests\UsuarioLeituraExcluirRequest;
use App\Http\Services\Usuario\UsuarioLeituraExcluir;
use Illuminate\Http\JsonResponse;

class UsuarioLeituraExcluirController extends Controller
{
    public function __construct(protected UsuarioLeituraExcluir $service) {}

    public function __invoke(UsuarioLeituraExcluirRequest $request): JsonResponse
    {
        try {
            $usuarioLeituraExcluirDTO = new UsuarioLeituraExcluirDTO($request->safe()->all());

            $this->service->usuarioLeituraExcluirLeitura($usuarioLeituraExcluirDTO);

            return ApiResponse::success(
                [],
                'Leitura Excluida com sucesso'
            );
        } catch (\Throwable $exception) {
            return ApiResponse::fromException($exception);
        }
    }
}
