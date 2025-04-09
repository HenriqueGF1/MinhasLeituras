<?php

namespace App\Http\Controllers\Services\Autor;

use App\Models\Autor;
use Exception;
use Illuminate\Support\Facades\DB;

class AutorService
{
    protected $model;

    public function __construct()
    {
        $this->model = new Autor;
    }

    public function cadastrarAutor($dados)
    {
        if ($this->model->where('nome', $dados['nome'])->exists()) {
            return $this->model->where('nome', '=', $dados['nome'])->first();
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
