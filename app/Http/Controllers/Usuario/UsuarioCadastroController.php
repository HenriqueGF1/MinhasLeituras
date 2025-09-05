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

    /**
     * @OA\Post(
     *   path="/api/usuario",
     *   summary="Realizar Cadastro do Usuário",
     *   description="Endpoint para Cadastro do Usuário",
     *   tags={"Usuario"},
     *
     *   @OA\RequestBody(
     *     required=true,
     *
     *     @OA\MediaType(
     *       mediaType="multipart/form-data",
     *
     *       @OA\Schema(
     *         type="object",
     *         required={},
     *
     *         @OA\Property(property="nome", type="string", description="Nome do Usuário"),
     *         @OA\Property(property="email", type="string", description="E-mail do Usuário"),
     *         @OA\Property(property="password", type="string", description="Senha do Usuário"),
     *         @OA\Property(property="data_nascimento", type="date", description="Data do Usuário"),
     *       )
     *     )
     *   ),
     *
     *   @OA\Response(
     *     response=201,
     *     description="Cadastro com sucesso",
     *
     *     @OA\JsonContent(
     *       type="object",
     *
     *       @OA\Property(property="success", type="boolean"),
     *       @OA\Property(property="message", type="string"),
     *       @OA\Property(property="data", ref="#")
     *     )
     *   ),
     *
     *   @OA\Response(
     *     response=400,
     *     description="Erro de validação nos campos enviados"
     *   ),
     *   @OA\Response(
     *     response=500,
     *     description="Erro interno no servidor"
     *   )
     * )
     */
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
