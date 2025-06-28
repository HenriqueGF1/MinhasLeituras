<?php

namespace App\Http\Services\Leituras;

use App\Http\DTO\LeituraDTO;
use App\Models\Leituras;
use Exception;
use Illuminate\Support\Facades\DB;

class LeituraPesquisa
{
    public function __construct(protected Leituras $model) {}

    public function pesquisaLeitura(LeituraDTO $leituraDto): ?Leituras
    {
        try {
            if (! is_null($leituraDto->id_leitura)) {
                $leitura = $this->model->find($leituraDto->id_leitura);

                if ($leitura) {
                    return $leitura;
                }
            }

            if (! is_null($leituraDto->titulo)) {
                $leitura = $this->model
                    ->where('titulo', 'LIKE', '%' . $leituraDto->titulo . '%')
                    ->first();

                if ($leitura) {
                    return $leitura;
                }
            }

            return null;
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
