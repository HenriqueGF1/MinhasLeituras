<?php

namespace App\Http\Controllers\Leituras;

use App\Http\Controllers\Controller;
use App\Http\Resources\Leitura\LeiturasResource;
use App\Http\Services\Leituras\IsbnPesquisa;
use Illuminate\Http\Request;

class IsbnPesquisaController extends Controller
{
    public function __construct(
        protected IsbnPesquisa $service
    ) {}

    public function __invoke(Request $request)
    {
        return new LeiturasResource(
            $this->service->pesquisaIsbnBase($request)
        );
    }
}
