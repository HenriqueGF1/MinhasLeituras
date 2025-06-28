<?php

namespace App\Http\Services\Editora;

use App\Http\DTO\EditoraDTO;
use App\Models\Editora;
use Exception;
use Illuminate\Support\Facades\DB;

class EditoraPesquisa
{
    public function __construct(protected Editora $model) {}

    public function pesquisaEditora(EditoraDTO $dto): ?Editora
    {
        try {
            if (! is_null($dto->id_editora)) {
                $editora = $this->model->find($dto->id_editora);

                if ($editora) {
                    return $editora;
                }
            }

            if (! is_null($dto->descricao_editora)) {
                $editora = $this->model
                    ->where('descricao', 'LIKE', '%' . $dto->descricao_editora . '%')
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
