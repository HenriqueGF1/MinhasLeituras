<?php

declare(strict_types=1);

namespace App\Http\Controllers\Services\Usuario;

use App\Models\UsuarioLeitura;
use Exception;
use Illuminate\Support\Facades\DB;

class UsuarioLeituraService
{
    protected $model;

    public function __construct()
    {
        $this->model = new UsuarioLeitura;
    }

    public function salvarLeituraUsuario($idLeitura, $dados)
    {
        if ($this->model->where('id_leitura', $idLeitura)->where('id_usuario', $dados['id_usuario'])->exists()) {
            return $this->model->where('id_leitura', $idLeitura)->where('id_usuario', $dados['id_usuario'])->first();
        }

        try {
            DB::beginTransaction();

            $usuarioLeitura = $this->model->create([
                'id_leitura' => $idLeitura,
                'id_usuario' => $dados['id_usuario'],
                'id_status_leitura' => $dados['id_status_leitura'],
            ]);

            DB::commit();

            return $usuarioLeitura;
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
