<?php

namespace App\Http\Controllers\Usuario;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\DTO\Usuario\UsuarioCadastroDTO;
use App\Http\Requests\Usuario\UserRequest;
use App\Http\Services\Usuario\UsuarioCadastro;
use Illuminate\Http\JsonResponse;

class UsuarioCadastroController extends Controller
{
    public function __construct(protected UsuarioCadastro $usuarioService) {}

    public function __invoke(UserRequest $request): JsonResponse
    {
        try {
            $dtoUsuarioCadastro = new UsuarioCadastroDTO($request->safe()->all());

            return $this->usuarioService->cadastroDeUsuario($dtoUsuarioCadastro);
        } catch (\Throwable $exception) {
            return ApiResponse::fromException($exception);
        }
    }
}
