<?php

namespace App\Http\Services\Leituras;

use App\Models\Leituras;
use Exception;
use Illuminate\Support\Facades\DB;

class LeituraPesquisa
{
    public function __construct(protected Leituras $model) {}

    public function pesquisaLeitura(int $id_leitura): Leituras
    {
        try {
            if ($this->model->where('id_leitura', $id_leitura)->exists()) {
                return $this->model->find($id_leitura);
            }

            throw new Exception("Leitura com ID {$id_leitura} não encontrada.");
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
