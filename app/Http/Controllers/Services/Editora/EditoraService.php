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
        // dd($dados);

        if ($this->model->where('descricao', $dados['descricao_editora'])->exists()) {
            return $this->model->where('descricao', '=', $dados['descricao_editora'])->first();
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
