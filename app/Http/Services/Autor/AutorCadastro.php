<?php

namespace App\Http\Services\Autor;

use App\Models\Autor;
use Exception;
use Illuminate\Support\Facades\DB;

class AutorCadastro
{
    public function __construct(protected Autor $model) {}

    public function cadastrarAutor(string $nome_autor): ?Autor
    {
        try {
            DB::beginTransaction();

            $autor = $this->model->create([
                'nome' => $nome_autor,
            ]);

            DB::commit();

            return $autor;
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
