<?php

namespace App\Http\Services\AvaliacaoLeitura;

use App\Models\AvaliacaoLeitura;
use Exception;
use Illuminate\Support\Facades\DB;

class AvaliacaoExcluir
{
    public function __construct(protected AvaliacaoLeitura $model) {}

    public function deletarAvaliacao(int $id_avaliacao_leitura): void
    {
        try {
            DB::beginTransaction();

            $avaliacaoLeitura = $this->model->findOrFail($id_avaliacao_leitura);

            $avaliacaoLeitura->delete();

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
