<?php

namespace App\Http\Controllers\Leituras;

use App\Helpers\ApiResponse;

use App\Http\Controllers\Controller;
use App\Http\DTO\LeituraProgresso\LeituraProgressoCadastroDTO;
use App\Http\Requests\Leitura\LeituraProgressoCadastroRequest;
use App\Http\Resources\Leitura\LeituraProgressoResource;
use App\Http\Services\Leituras\LeituraProgresso\LeituraProgressoCadastro;
use Illuminate\Http\JsonResponse;

class LeituraProgressoController extends Controller
{
    public function __construct(protected LeituraProgressoCadastro $leituraProgressoCadastroService) {}

    public function __invoke(LeituraProgressoCadastroRequest $request): JsonResponse
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
