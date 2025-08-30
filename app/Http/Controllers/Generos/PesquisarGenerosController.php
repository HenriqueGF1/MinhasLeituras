<?php

namespace App\Http\Controllers\Generos;

use App\Http\Controllers\Controller;
use App\Http\Resources\Generos\GenerosResource;
use App\Http\Services\Genero\GenerosPesquisa;

class PesquisarGenerosController extends Controller
{
    public function __construct(
        protected GenerosPesquisa $serviceGenerosPesquisa
    ) {}

    public function __invoke()
    {
        return GenerosResource::collection(
            $this->serviceGenerosPesquisa->listarGenerosLeitura()
        );
    }
}
