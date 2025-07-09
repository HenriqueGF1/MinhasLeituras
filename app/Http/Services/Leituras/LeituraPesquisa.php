<?php

namespace App\Http\Services\Leituras;

use App\Http\DTO\Leitura\LeituraPesquisaDTO;
use App\Models\Leituras;

class LeituraPesquisa
{
    public function __construct(protected Leituras $model) {}

    public function pesquisaLeitura(LeituraPesquisaDTO $leituraDto): ?Leituras
    {
        $leitura = null;

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

        return $leitura;
    }
}
