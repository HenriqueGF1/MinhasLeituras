<?php

namespace App\Http\Services\AvaliacaoLeitura;

use App\Http\DTO\AvaliacaoLeitura\AvaliacaoLeituraExcluirDTO;
use App\Models\AvaliacaoLeitura;
use Exception;
use Illuminate\Support\Facades\DB;

class AvaliacaoExcluir
{
    public function __construct(protected AvaliacaoLeitura $model) {}

    public function deletarAvaliacao(AvaliacaoLeituraExcluirDTO $dto): void
    {
        try {
            DB::beginTransaction();

            $avaliacaoLeitura = $this->model->findOrFail($dto->id_avaliacao_leitura);

            $avaliacaoLeitura->delete();

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
