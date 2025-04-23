<?php

namespace App\Http\Services\Editora;

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
        $valor = isset($dados['descricao_editora']) ? $dados['descricao_editora'] : $dados['id_editora'];
        $campo = isset($dados['descricao_editora']) ? 'descricao' : 'id_editora';

        if ($this->model->where($campo, $valor)->exists()) {
            return $this->model->where($campo, '=', $valor)->first();
        }

        try {
            DB::beginTransaction();

            $editora = $this->model->create([
                'descricao' => $dados['descricao_editora'],
            ]);

            DB::commit();

            return $editora;
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
