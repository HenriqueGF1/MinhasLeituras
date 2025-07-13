<?php

namespace App\Http\Services\Usuario\Leitura;

use App\Http\DTO\UsuarioLeitura\UsuarioLeituraAtualizarDTO;
use App\Models\StatusLeitura;
use App\Models\UsuarioLeitura;
use Exception;
use Illuminate\Support\Facades\DB;

class UsuarioLeituraAtualizar
{
    public function __construct(protected UsuarioLeitura $model) {}

    public function atualizarLeituraDoUsuario(UsuarioLeituraAtualizarDTO $usuarioLeituraDTO): ?UsuarioLeitura
    {
        DB::beginTransaction();

        $statusValido = array_key_exists($usuarioLeituraDTO->id_status_leitura, StatusLeitura::pegarStatus());

        if (! $statusValido) {
            throw new \InvalidArgumentException("Status inválido: {$usuarioLeituraDTO->id_status_leitura}");
        }

        try {
            $usuarioLeitura = $this->model
                ->where('id_usuario_leitura', $usuarioLeituraDTO->id_usuario_leitura)
                ->firstOrFail();

            $usuarioLeitura->update([
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
