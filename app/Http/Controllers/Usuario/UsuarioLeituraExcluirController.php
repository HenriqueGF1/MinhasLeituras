<?php

namespace App\Http\Controllers\Usuario;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\DTO\UsuarioLeitura\UsuarioLeituraExcluirDTO;
use App\Http\Requests\Usuario\UsuarioLeituraExcluirRequest;
use App\Http\Services\Usuario\Leitura\UsuarioLeituraExcluir;
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
