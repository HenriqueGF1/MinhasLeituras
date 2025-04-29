<?php

namespace App\Http\Services\Autor;

use App\Models\Autor;
use Exception;
use Illuminate\Support\Facades\DB;

class AutorService
{
    protected Autor $model;

    public function __construct(Autor $model)
    {
        $this->model = $model;
    }

    public function cadastrarAutor($dados)
    {
        $valor = isset($dados['nome']) ? $dados['nome'] : $dados['id_autor'];
        $campo = isset($dados['nome']) ? 'nome' : 'id_autor';

        if ($this->model->where($campo, $valor)->exists()) {
            return $this->model->where($campo, '=', $valor)->first();
        }

        try {
            DB::beginTransaction();

            $autor = $this->model->create([
                'nome' => $dados['nome'],
            ]);

            DB::commit();

            return $autor;
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
