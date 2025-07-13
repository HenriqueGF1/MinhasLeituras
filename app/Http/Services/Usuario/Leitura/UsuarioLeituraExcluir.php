<?php

namespace App\Http\Services\Usuario\Leitura;

use App\Http\DTO\UsuarioLeitura\UsuarioLeituraExcluirDTO;
use App\Models\UsuarioLeitura;
use Exception;
use Illuminate\Support\Facades\DB;

class UsuarioLeituraExcluir
{
    public function __construct(protected UsuarioLeitura $model) {}

    public function usuarioLeituraExcluirLeitura(UsuarioLeituraExcluirDTO $dto): void
    {
        try {
            DB::beginTransaction();

            $usuarioLeitura = $this->model->findOrFail($dto->id_usuario_leitura);

            $usuarioLeitura->delete();

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
