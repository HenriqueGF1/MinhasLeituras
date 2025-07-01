<?php

namespace App\Http\Services\Autor;

use App\Http\DTO\Autor\AutorPesquisaDTO;
use App\Models\Autor;
use Exception;
use Illuminate\Support\Facades\DB;

class AutorPesquisa
{
    public function __construct(protected Autor $model) {}

    public function pesquisaAutor(AutorPesquisaDTO $autorDto): ?Autor
    {
        try {
            if (! is_null($autorDto->id_autor)) {
                $autor = $this->model->find($autorDto->id_autor);

                if ($autor) {
                    return $autor;
                }
            }

            if (! is_null($autorDto->nome_autor)) {
                $autor = $this->model
                    ->where('nome', 'LIKE', '%' . $autorDto->nome_autor . '%')
                    ->first();

                if ($autor) {
                    return $autor;
                }
            }

            return null;
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
