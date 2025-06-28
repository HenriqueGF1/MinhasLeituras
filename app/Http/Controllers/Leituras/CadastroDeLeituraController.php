<?php

namespace App\Http\Controllers\Leituras;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\DTO\CadastroLeituraDTO;
use App\Http\Requests\LeiturasRequest;
use App\Http\Resources\LeiturasResource;
use App\Http\Services\Leituras\CadastramentoDeLeituraFacade;
use Illuminate\Http\JsonResponse;

class CadastroDeLeituraController extends Controller
{
    public function __construct(
        protected CadastramentoDeLeituraFacade $cadastramentoDeLeituraFacade
    ) {}

    public function __invoke(LeiturasRequest $request): JsonResponse
    {
        try {
            $dtoLeitura = new CadastroLeituraDTO($request->safe()->all());

            $leitura = $this->cadastramentoDeLeituraFacade->processoDeCadastroDeLeitura($dtoLeitura);

            return ApiResponse::success(
                new LeiturasResource($leitura),
                'Leitura cadastrada com sucesso'
            );
        } catch (\Throwable $exception) {
            return ApiResponse::fromException($exception);
        }
    }
}
