<?php

namespace App\Http\Services\Editora;

use App\Models\Editora;
use Exception;
use Illuminate\Support\Facades\DB;

class EditoraPesquisa
{
    public function __construct(protected Editora $model) {}

    public function pesquisaEditora(?int $id_editora = null, ?string $descricao = null): ?Editora
    {
        try {
            if (! is_null($id_editora)) {
                $editora = $this->model->find($id_editora);

                if ($editora) {
                    return $editora;
                }
            }

            if (! is_null($descricao)) {
                $editora = $this->model
                    ->where('descricao', 'LIKE', '%' . $descricao . '%')
                    ->first();

                if ($editora) {
                    return $editora;
                }
            }

            return null;
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
