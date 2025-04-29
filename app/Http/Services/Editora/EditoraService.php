<?php

namespace App\Http\Services\Editora;

use App\Models\Editora;
use Exception;
use Illuminate\Support\Facades\DB;

class EditoraService
{
    protected Editora $model;

    public function __construct(Editora $model)
    {
        $this->model = $model;
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
