<?php

namespace App\Http\Controllers\Leituras;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\DTO\Leitura\CadastroLeituraDto;
use App\Http\Facades\Leitura\CadastramentoDeLeituraFacade;
use App\Http\Requests\Leitura\LeiturasRequest;
use App\Http\Resources\Leitura\LeiturasResource;
use Illuminate\Http\JsonResponse;

class CadastroDeLeituraController extends Controller
{
    public function __construct(
        protected CadastramentoDeLeituraFacade $cadastramentoDeLeituraFacade
    ) {}

    public function __invoke(LeiturasRequest $request): JsonResponse
    {
        try {
            $dtoLeitura = new CadastroLeituraDto($request->safe()->all());

            $leitura = $this->cadastramentoDeLeituraFacade->processoDeCadastroDeLeitura($dtoLeitura);

            return ApiResponse::success(
                new LeiturasResource($leitura),
                'Leitura cadastrada com sucesso',
                201
            );
        } catch (\Throwable $exception) {
            return ApiResponse::fromException($exception);
        }
    }
}
