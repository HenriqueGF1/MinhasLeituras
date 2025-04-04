<?php

namespace App\Http\Controllers\Services\Editora;

use App\Models\Editora;
use Exception;
use Illuminate\Support\Facades\DB;

class EditoraService
{
    protected $model;

    public function __construct()
    {
        $this->model = new Editora;
    }

    public function cadastrarEditora($dados)
    {
        // dd('EditoraService', $dados);

        if ($this->model->where('descricao', $dados['descricao_editora'])->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'A editora já existe',
                'data' => $this->model->where('descricao', '=', $dados['descricao_editora'])->first(),
            ], 409);
        }

        try {
            DB::beginTransaction();

            $editora = $this->model->create([
                'descricao' => $dados['descricao_editora'],
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Sucesso Cadastro de Editora',
                'data' => $editora,
            ], 201);
        } catch (Exception $exception) {
            DB::rollBack();

            throw new Exception(json_encode([
                'success' => false,
                'msg' => 'Erro ao cadastrar editora',
                'erroDev' => $exception->getMessage(),
            ]));
        }
    }
}
