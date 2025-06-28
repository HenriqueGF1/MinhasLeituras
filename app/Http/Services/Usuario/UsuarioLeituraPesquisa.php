<?php

namespace App\Http\Services\Usuario;

use App\Models\UsuarioLeitura;
use Exception;
use Illuminate\Support\Facades\DB;

class UsuarioLeituraPesquisa
{
    public function __construct(protected UsuarioLeitura $model) {}

    public function pesquisaLeituraUsuario(int $id_leitura): ?UsuarioLeitura
    {
        try {
            if (! is_null($id_leitura)) {
                $leitura = $this->model->find($id_leitura);

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
