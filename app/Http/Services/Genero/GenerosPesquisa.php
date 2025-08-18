<?php

namespace App\Http\Services\Genero;

use App\Models\Genero;
use Illuminate\Database\Eloquent\Collection;

class GenerosPesquisa
{
    public function __construct(protected Genero $model) {}

    public function listarGenerosLeitura(): ?Collection
    {
        return $this->model->get();
    }
}
