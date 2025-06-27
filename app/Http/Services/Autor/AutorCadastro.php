<?php

namespace App\Http\Services\Autor;

use App\Models\Autor;
use Exception;
use Illuminate\Support\Facades\DB;

class AutorCadastro
{
    public function __construct(protected Autor $model) {}

    public function cadastrarAutor(array $dados = []): ?Autor
    {
        $valor = isset($dados['nome_autor']) ? $dados['nome_autor'] : $dados['id_autor'];
        $campo = isset($dados['nome_autor']) ? 'nome_autor' : 'id_autor';

        if ($this->model->where($campo, $valor)->exists()) {
            return $this->model->where($campo, '=', $valor)->first();
        }

        try {
            DB::beginTransaction();

            $autor = $this->model->create([
                'nome' => $dados['nome_autor'],
            ]);

            DB::commit();

            return $autor;
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
