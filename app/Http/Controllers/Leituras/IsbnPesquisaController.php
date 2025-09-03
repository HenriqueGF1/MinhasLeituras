<?php

namespace App\Http\Controllers\Leituras;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Leitura\IsbnRequest;
use App\Http\Resources\Leitura\LeiturasResource;
use App\Http\Services\Leituras\IsbnPesquisa;

class IsbnPesquisaController extends Controller
{
    public function __construct(
        protected IsbnPesquisa $service
    ) {}

    public function __invoke(IsbnRequest $request)
    {
        $leitura = $this->service->pesquisaIsbnBase($request->isbn);

        if (! is_null($leitura)) {
            return ApiResponse::success(
                new LeiturasResource(
                    $this->service->pesquisaIsbnBase($request->isbn)
                ),
                'Leitura',
                200
            );
        }

        return ApiResponse::success(
            [],
            'Leitura',
            200
        );
    }
}
