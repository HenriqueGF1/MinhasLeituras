<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Http\Services\Usuario\UsuarioLogout;

class UsuarioLogoutController extends Controller
{
    public function __construct(protected UsuarioLogout $usuarioLogoutService) {}

    /**
     * @OA\Get(
     *   path="/api/usuario/logout",
     *   summary="Realizar Logout do Usuário",
     *   description="Endpoint para logout do usuário autenticado",
     *   tags={"Usuario"},
     *   security={{"bearerAuth":{}}},
     *
     *   @OA\Response(
     *     response=200,
     *     description="Logout realizado com sucesso",
     *
     *     @OA\JsonContent(
     *       type="object",
     *
     *       @OA\Property(property="success", type="boolean"),
     *       @OA\Property(property="message", type="string"),
     *       @OA\Property(property="data", type="object", description="Dados adicionais, se houver")
     *     )
     *   ),
     *
     *   @OA\Response(
     *     response=401,
     *     description="Não autorizado, token inválido ou ausente"
     *   ),
     *   @OA\Response(
     *     response=500,
     *     description="Erro interno no servidor"
     *   )
     * )
     */
    public function __invoke()
    {
        return $this->usuarioLogoutService->logout();
    }
}
