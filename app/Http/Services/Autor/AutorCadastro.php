<?php

namespace App\Http\Services\Autor;

use App\Http\DTO\Autor\AutorCadastroDTO;
use App\Models\Autor;
use Exception;
use Illuminate\Support\Facades\DB;

class AutorCadastro
{
    public function __construct(protected Autor $model) {}

    public function cadastrarAutor(AutorCadastroDTO $autorDTO): ?Autor
    {
        try {
            DB::beginTransaction();

            $autor = $this->model->create($autorDTO->toArray());

            DB::commit();

            return $autor;
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
