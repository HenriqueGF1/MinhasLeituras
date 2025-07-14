<?php

namespace App\Http\Services\Leituras\LeituraProgresso;

use App\Helpers\ApiResponse;
use App\Http\DTO\LeituraProgresso\LeituraProgressoCadastroDTO;
use App\Http\DTO\Usuarioleitura\UsuarioLeituraPesquisaDTO;
use App\Http\Requests\Leitura\LeituraProgressoCadastroRequest;
use App\Http\Resources\Leitura\LeituraProgressoResource;
use App\Http\Services\Usuario\Leitura\UsuarioLeituraPesquisa;
use App\Models\StatusLeitura;
use Illuminate\Http\JsonResponse;

class LeituraProgressoCadastramento
{
    public function __construct(
        protected LeituraProgressoCadastro $leituraProgressoCadastroService,
        protected UsuarioLeituraPesquisa $usuarioLeituraPesquisaService,
    ) {}

    public function cadastramentoLeituraProgesso(LeituraProgressoCadastroRequest $request): JsonResponse
    {
        try {
            $dtoLeituraProgressoCadastroDTO = new LeituraProgressoCadastroDTO($request->safe()->all());
            $dtoUsuarioLeituraPesquisa = new UsuarioLeituraPesquisaDTO($request->safe()->all());

            $pesquisaLeituraUsuario = $this->usuarioLeituraPesquisaService->pesquisaLeituraUsuario($dtoUsuarioLeituraPesquisa);

            if ($pesquisaLeituraUsuario->id_status_leitura != StatusLeitura::STATUS_LIDO) {
                $leituraProgressoCadastro = $this->leituraProgressoCadastroService->cadastrarProgresso($dtoLeituraProgressoCadastroDTO);

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
