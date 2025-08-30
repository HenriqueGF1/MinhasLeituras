<?php

namespace App\Http\Controllers\UsuarioLeituras;

use App\Http\Controllers\Controller;
use App\Http\Resources\UsuarioLeitura\UsuarioLeituraResource;
use App\Http\Services\Usuario\Leitura\LeiturasPesquisa;

/**
 * @OA\PathItem(path="/api/leituras")
 */
class PesquisarLeiturasUsuariosController extends Controller
{
    public function __construct(
        protected LeiturasPesquisa $service
    ) {}

    public function __invoke()
    {
        return UsuarioLeituraResource::collection(
            $this->service->pesquisaLeiturasUsuario()
        );
    }
}
