<?php

namespace App\Http\Services\Autor;

use App\Models\Autor;
use Illuminate\Database\Eloquent\Collection;

class AutoresPesquisa
{
    public function __construct(protected Autor $model) {}

    public function listarAutores(): ?Collection
    {
        return $this->model->get();
    }
}
