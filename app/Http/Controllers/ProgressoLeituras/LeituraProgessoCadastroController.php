<?php

namespace App\Http\Controllers\ProgressoLeituras;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProgressoLeitura\LeituraProgressoCadastroRequest;
use App\Http\Services\Leituras\LeituraProgresso\LeituraProgressoCadastramento;
use Illuminate\Http\JsonResponse;

class LeituraProgessoCadastroController extends Controller
{
    public function __construct(
        protected LeituraProgressoCadastramento $leituraProgressoCadastramentoService,
    ) {}

    public function __invoke(LeituraProgressoCadastroRequest $request): JsonResponse
    {
        return $this->leituraProgressoCadastramentoService->cadastramentoLeituraProgesso($request);
    }
}
