<?php

namespace App\Http\Services\Autor;

use App\Http\DTO\Autor\AutorPesquisaDTO;
use App\Models\Autor;
use Exception;
use Illuminate\Support\Facades\DB;

class AutorPesquisa
{
    public function __construct(protected Autor $model) {}

    public function pesquisaAutor(AutorPesquisaDTO $autorDto): Autor
    {
        try {
            $autorPesquisa = null;

            if (! is_null($autorDto->id_autor)) {
                $autorPesquisa = $this->model->find($autorDto->id_autor);

                if ($autorPesquisa) {
                    return $autorPesquisa;
                }
            }

            if (! is_null($autorDto->nome_autor)) {
                $autorPesquisa = $this->model
                    ->where('nome', 'LIKE', '%' . $autorDto->nome_autor . '%')
                    ->first();

                if ($autorPesquisa) {
                    return $autorPesquisa;
                }
            }

            return $autorPesquisa;
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
