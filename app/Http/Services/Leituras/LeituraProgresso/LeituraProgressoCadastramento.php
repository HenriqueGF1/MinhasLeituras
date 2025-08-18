<?php

namespace App\Http\Services\Leituras\LeituraProgresso;

use App\Helpers\ApiResponse;
use App\Http\DTO\LeituraProgresso\LeituraProgressoCadastroDTO;
use App\Http\Requests\Leitura\LeituraProgressoCadastroRequest;
use App\Http\Resources\Leitura\LeituraProgressoResource;
use Illuminate\Http\JsonResponse;

class LeituraProgressoCadastramento
{
    public function __construct(
        protected LeituraProgressoCadastro $leituraProgressoCadastroService,
    ) {}

    public function cadastramentoLeituraProgesso(LeituraProgressoCadastroRequest $request): JsonResponse
    {
        try {
            $dtoLeituraProgressoCadastroDTO = new LeituraProgressoCadastroDTO($request->safe()->all());

            $leituraProgressoCadastro = $this->leituraProgressoCadastroService->cadastrarProgresso($dtoLeituraProgressoCadastroDTO);

            if (! empty($leituraProgressoCadastro->id_leitura_progresso)) {
                return ApiResponse::success(
                    new LeituraProgressoResource($leituraProgressoCadastro),
                    'Progresso da Leitura cadastrado com sucesso',
                    201
                );
            }

            return ApiResponse::success(
                [],
                'Progresso da Leitura não disponivel',
                409
            );
        } catch (\Throwable $exception) {
            return ApiResponse::fromException($exception);
        }
    }
}
