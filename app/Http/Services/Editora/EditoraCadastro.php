<?php

namespace App\Http\Services\Editora;

use App\Http\DTO\Editora\EditoraCadastroDTO;
use App\Models\Editora;
use Exception;
use Illuminate\Support\Facades\DB;

class EditoraCadastro
{
    public function __construct(protected Editora $model) {}

    public function cadastrarEditora(EditoraCadastroDTO $editoraDTO): Editora
    {
        try {
            DB::beginTransaction();

            $editora = $this->model->create([
                'descricao' => $editoraDTO->descricao_editora,
            ]);

            DB::commit();

            return $editora;
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
