<?php

namespace App\Http\Controllers\UsuarioLeituras;

use App\Http\Controllers\Controller;
use App\Http\Resources\UsuarioLeitura\UsuarioLeituraResource;
use App\Http\Services\Usuario\Leitura\LeiturasPesquisa;

class PesquisarLeiturasUsuariosController extends Controller
{
    public function __construct(
        protected LeiturasPesquisa $service
    ) {}

    /**
     * @OA\Get(
     *   path="/api/usuario-leitura",
     *   summary="Pesquisar Leituras do Usuário",
     *   description="Pesquisar Leituras do Usuário",
     *   tags={"Usuario Leituras"},
     *   security={{"bearerAuth":{}}},
     *
     *   @OA\Parameter(
     *      name="token",
     *                                         in="query",
     *      required=true,
     *      description="Token de autenticação do usuário",
     *
     *      @OA\Schema(type="string")
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
        return UsuarioLeituraResource::collection(
            $this->service->pesquisaLeiturasUsuario()
        );
    }
}
