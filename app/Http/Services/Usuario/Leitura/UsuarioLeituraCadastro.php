<?php

namespace App\Http\Services\Usuario\Leitura;

use App\Http\DTO\UsuarioLeitura\UsuarioLeituraCadastroDTO;
use App\Models\UsuarioLeitura;
use Exception;
use Illuminate\Support\Facades\DB;

class UsuarioLeituraCadastro
{
    public function __construct(protected UsuarioLeitura $model) {}

    public function cadastrarLeituraDoUsuario(UsuarioLeituraCadastroDTO $usuarioLeituraDTO): ?UsuarioLeitura
    {
        DB::beginTransaction();

        try {
            $usuarioLeitura = $this->model->create([
                'id_leitura' => $usuarioLeituraDTO->id_leitura,
                'id_usuario' => $usuarioLeituraDTO->id_usuario,
                'id_status_leitura' => $usuarioLeituraDTO->id_status_leitura,
            ]);

            DB::commit();

            return $usuarioLeitura;
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
