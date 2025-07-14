<?php

namespace App\Http\Controllers\Leituras;

use App\Http\Controllers\Controller;
use App\Http\Requests\Leitura\LeituraProgressoCadastroRequest;
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
