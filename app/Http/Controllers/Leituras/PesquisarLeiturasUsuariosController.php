<?php

namespace App\Http\Controllers\Leituras;

use App\Http\Controllers\Controller;
use App\Http\Resources\Leitura\LeiturasResource;
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
        // return LeiturasResource::collection(
        return $this->service->pesquisaLeiturasUsuario();
        // );
    }
}
