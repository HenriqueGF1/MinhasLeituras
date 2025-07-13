<?php

namespace App\Http\Services\AvaliacaoLeitura;

use App\Http\DTO\AvaliacaoLeitura\AvaliacaoLeituraCadastroDTO;
use App\Models\AvaliacaoLeitura;
use Exception;
use Illuminate\Support\Facades\DB;

class AvaliacaoLeituraCadastro
{
    public function __construct(protected AvaliacaoLeitura $model) {}

    public function cadastroDeAvaliacaoDeLeitura(AvaliacaoLeituraCadastroDTO $dtoAvaliacaoLeituraCadastroDTO): AvaliacaoLeitura
    {
        try {
            DB::beginTransaction();

            $avaliacaoLeitura = $this->model->create($dtoAvaliacaoLeituraCadastroDTO->toArray());

            DB::commit();

            return $avaliacaoLeitura;
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
