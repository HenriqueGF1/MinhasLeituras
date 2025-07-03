<?php

namespace App\Http\Services\Usuario;

use App\Http\DTO\Usuarioleitura\UsuarioLeituraPesquisaDTO;
use App\Models\UsuarioLeitura;
use Exception;
use Illuminate\Support\Facades\DB;

class UsuarioLeituraPesquisa
{
    public function __construct(protected UsuarioLeitura $model) {}

    public function pesquisaLeituraUsuario(UsuarioLeituraPesquisaDTO $dto): ?UsuarioLeitura
    {
        try {
            $leitura = $this->model
                ->where('id_usuario', $dto->id_usuario)
                ->where('id_leitura', $dto->id_leitura)
                ->first();

            if ($leitura) {
                return $leitura;
            }

            return null;
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
