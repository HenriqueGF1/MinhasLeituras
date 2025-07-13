<?php

namespace App\Http\Services\Usuario\Leitura;

use App\Http\DTO\UsuarioLeitura\UsuarioLeituraCadastroDTO;
use App\Models\StatusLeitura;
use App\Models\UsuarioLeitura;
use Exception;
use Illuminate\Support\Facades\DB;

class UsuarioLeituraCadastro
{
    public function __construct(protected UsuarioLeitura $model) {}

    public function cadastrarLeituraDoUsuario(UsuarioLeituraCadastroDTO $usuarioLeituraDTO): ?UsuarioLeitura
    {
        DB::beginTransaction();

        $statusValido = array_key_exists($usuarioLeituraDTO->id_status_leitura, StatusLeitura::pegarStatus());

        if (! $statusValido) {
            throw new \InvalidArgumentException("Status inválido: {$usuarioLeituraDTO->id_status_leitura}");
        }

        try {
            $usuarioLeitura = $this->model->create([
                'id_leitura' => $usuarioLeituraDTO->id_leitura,
                'id_usuario' => $usuarioLeituraDTO->id_usuario,
                'id_status_leitura' => $statusValido,
            ]);

            DB::commit();

            return $usuarioLeitura;
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
