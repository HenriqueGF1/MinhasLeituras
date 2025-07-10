<?php

namespace App\Http\Controllers\Leituras;

use App\Helpers\ApiResponse;

use App\Http\Controllers\Controller;
use App\Http\DTO\LeituraProgresso\LeituraProgressoCadastroDTO;
use App\Http\Requests\LeituraProgressoRequest;
use App\Http\Resources\LeituraProgressoResource;
use App\Http\Services\LeituraProgresso\LeituraProgressoCadastroService;

class LeituraProgressoController extends Controller
{
    public function __construct(protected LeituraProgressoCadastroService $leituraProgressoCadastroService) {}

    public function __invoke(LeituraProgressoRequest $request)
    {
        try {
            $dtoLeituraProgressoCadastroDTO = new LeituraProgressoCadastroDTO($request->safe()->all());

            $leituraProgresso = $this->leituraProgressoCadastroService->cadastrarProgresso($dtoLeituraProgressoCadastroDTO);

            return ApiResponse::success(
                new LeituraProgressoResource($leituraProgresso),
                'Progresso da Leitura cadastrado com sucesso'
            );
        } catch (\Throwable $exception) {
            return ApiResponse::fromException($exception);
        }
    }
}
