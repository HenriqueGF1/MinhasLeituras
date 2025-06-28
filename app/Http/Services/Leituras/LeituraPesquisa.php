<?php

namespace App\Http\Services\Leituras;

use App\Models\Leituras;
use Exception;
use Illuminate\Support\Facades\DB;

class LeituraPesquisa
{
    public function __construct(protected Leituras $model) {}

    public function pesquisaLeitura(int $id_leitura, ?string $titulo = null): ?Leituras
    {
        try {
            if (! is_null($id_leitura)) {
                $leitura = $this->model->find($id_leitura);

                if ($leitura) {
                    return $leitura;
                }
            }

            if (! is_null($titulo)) {
                $leitura = $this->model
                    ->where('titulo', 'LIKE', '%' . $titulo . '%')
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
