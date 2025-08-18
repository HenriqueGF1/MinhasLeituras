<?php

namespace App\Http\Services\Editora;

use App\Models\Editora;
use Illuminate\Database\Eloquent\Collection;

class EditorasPesquisa
{
    public function __construct(protected Editora $model) {}

    public function listarEditoras(): ?Collection
    {
        return $this->model->get();
    }
}
