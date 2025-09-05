<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Http\Requests\Usuario\UsuarioLoginRequest;
use App\Http\Services\Usuario\UsuarioLogin;

class UsuarioLoginController extends Controller
{
    public function __construct(protected UsuarioLogin $usuarioLoginService) {}

    /**
     * @OA\Post(
     *   path="/api/usuario/login",
     *   summary="Realizar Login do Usuário",
     *   description="Endpoint para Login do Usuário",
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
     *         @OA\Property(property="email", type="string", description="E-mail do Usuário"),
     *         @OA\Property(property="password", type="string", description="Senha do Usuário"),
     *       )
     *     )
     *   ),
     *
     *   @OA\Response(
     *     response=201,
     *     description="Login com sucesso",
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
    public function __invoke(UsuarioLoginRequest $request)
    {
        return $this->usuarioLoginService->login($request);
    }
}
