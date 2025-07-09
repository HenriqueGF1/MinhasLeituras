<?php

namespace App\Http\Services\Editora;

use App\Http\DTO\Editora\EditoraPesquisaDTO;
use App\Models\Editora;

class EditoraPesquisa
{
    public function __construct(protected Editora $model) {}

    public function pesquisaEditora(EditoraPesquisaDTO $dto): ?Editora
    {
        $editoraPesquisa = null;

        if (! is_null($dto->id_editora)) {
            $editoraPesquisa = $this->model->find($dto->id_editora);

            if ($editoraPesquisa) {
                return $editoraPesquisa;
            }
        }

        if (! is_null($dto->descricao_editora)) {
            $editoraPesquisa = $this->model
                ->where('descricao', 'LIKE', '%' . $dto->descricao_editora . '%')
                ->first();

            if ($editoraPesquisa) {
                return $editoraPesquisa;
            }
        }

        return $editoraPesquisa;
    }
}
