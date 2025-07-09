<?php

namespace App\Http\Services\Leituras;

use App\Http\DTO\Leitura\LeituraCadastroDTO;
use App\Models\Leituras;
use Exception;
use Illuminate\Support\Facades\DB;

class LeituraCadastro
{
    public function __construct(protected Leituras $model) {}

    public function cadastroDeLeitura(LeituraCadastroDTO $leituraDto): Leituras
    {
        try {
            DB::beginTransaction();

            $leitura = $this->model->create($leituraDto->toArray());

            DB::commit();

            return $leitura;
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
