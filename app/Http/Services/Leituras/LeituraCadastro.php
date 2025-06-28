<?php

namespace App\Http\Services\Leituras;

use App\Models\Leituras;
use Exception;
use Illuminate\Support\Facades\DB;

class LeituraCadastro
{
    public function __construct(protected Leituras $model, protected LeituraPesquisa $pesquisaLeitura) {}

    public function cadastroDeLeitura(array $dados = []): Leituras
    {
        DB::beginTransaction();

        try {
            $leitura = Leituras::create($dados);

            DB::commit();

            return $leitura;
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
