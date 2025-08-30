<?php

namespace App\Http\Controllers\UsuarioLeituras;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\DTO\UsuarioLeitura\UsuarioLeituraCadastroDTO;
use App\Http\Requests\Usuario\UsuarioLeituraCadastroRequest;
use App\Http\Services\Usuario\Leitura\UsuarioLeituraCadastro;
use Illuminate\Http\JsonResponse;

class UsuarioLeituraCadastrarController extends Controller
{
    public function __construct(protected UsuarioLeituraCadastro $service) {}

    public function __invoke(UsuarioLeituraCadastroRequest $request): JsonResponse
    {
        try {
            $usuarioLeituraExcluirDTO = new UsuarioLeituraCadastroDTO($request->safe()->all());

            $usuarioLeitura = $this->service->cadastrarLeituraDoUsuario($usuarioLeituraExcluirDTO);

            return ApiResponse::success(
                $usuarioLeitura,
                'Leitura Cadastrada com sucesso'
            );
        } catch (\Throwable $exception) {
            return ApiResponse::fromException($exception);
        }
    }
}
