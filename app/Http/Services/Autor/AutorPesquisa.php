<?php

namespace App\Http\Services\Autor;

use App\Models\Autor;
use Exception;
use Illuminate\Support\Facades\DB;

class AutorPesquisa
{
    public function __construct(protected Autor $model) {}

    public function pesquisaAutor(?int $id_autor = null, ?string $nomeAutor = null): ?Autor
    {
        try {
            if (! is_null($id_autor)) {
                $autor = $this->model->find($id_autor);

                if ($autor) {
                    return $autor;
                }
            }

            if (! is_null($nomeAutor)) {
                $autor = $this->model
                    ->where('nome', 'LIKE', '%' . $nomeAutor . '%')
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
