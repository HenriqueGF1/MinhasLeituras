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
        if ($this->model->where('id_leitura', $idLeitura)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'O usuário já possui essa leitura',
            ], 409);
        }

        try {
            DB::beginTransaction();

            $usuarioLeitura = $this->model->create([
                'id_leitura' => $idLeitura,
                'id_usuario' => $dados['id_usuario'],
                'id_status_leitura' => $dados['id_status_leitura'],
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Leitura associada ao usuário com sucesso',
                'data' => $usuarioLeitura,
            ], 201);
        } catch (Exception $exception) {
            DB::rollBack();

            throw new Exception(json_encode([
                'success' => false,
                'msg' => 'Erro ao cadastrar leitura para o usuário',
                'erroDev' => $exception->getMessage(),
            ]));
        }
    }
}
