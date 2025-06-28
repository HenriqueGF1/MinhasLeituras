<?php

namespace App\Http\Services\Autor;

use App\Http\DTO\AutorDTO;
use App\Models\Autor;
use Exception;
use Illuminate\Support\Facades\DB;

class AutorCadastro
{
    public function __construct(protected Autor $model) {}

    public function cadastrarAutor(AutorDTO $autorDTO): ?Autor
    {
        try {
            DB::beginTransaction();

            $autor = $this->model->create([
                'nome' => $autorDTO->nome_autor,
            ]);

            DB::commit();

            return $autor;
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
