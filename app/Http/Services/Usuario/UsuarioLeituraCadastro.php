<?php

declare(strict_types=1);

namespace App\Http\Services\Usuario;

use App\Models\StatusLeitura;
use App\Models\UsuarioLeitura;
use Exception;
use Illuminate\Support\Facades\DB;

class UsuarioLeituraCadastro
{
    public function __construct(protected UsuarioLeitura $model) {}

    public function cadastrarLeituraDoUsuario(int $idLeitura, array $dados): ?UsuarioLeitura
    {
        if ($this->model->where('id_leitura', $idLeitura)->where('id_usuario', $dados['id_usuario'])->exists()) {
            return $this->model->where('id_leitura', $idLeitura)->where('id_usuario', $dados['id_usuario'])->first();
        }

        DB::beginTransaction();

        $statusValido = array_key_exists($dados['id_status_leitura'], StatusLeitura::pegarStatus());

        if (! $statusValido) {
            throw new \InvalidArgumentException("Status inválido: {$dados['id_status_leitura']}");
        }

        try {
            $usuarioLeitura = $this->model->create([
                'id_leitura' => $idLeitura,
                'id_usuario' => $dados['id_usuario'],
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
