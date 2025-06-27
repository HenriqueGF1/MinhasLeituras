<?php

namespace App\Http\Controllers\Leituras;

use App\Http\Controllers\Controller;
use App\Http\Resources\LeiturasResource;
use App\Http\Services\Leituras\IsbnConsultaService;
use Illuminate\Http\Request;

class IsbnPesquisaController extends Controller
{
    public function __construct(
        protected IsbnConsultaService $service
    ) {}

    public function __invoke(Request $request)
    {
        return new LeiturasResource(
            $this->service->pesquisaIsbnBase($request)
        );
    }
}
