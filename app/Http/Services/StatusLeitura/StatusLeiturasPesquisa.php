<?php

namespace App\Http\Services\StatusLeitura;

use App\Models\StatusLeitura;
use Illuminate\Database\Eloquent\Collection;

class StatusLeiturasPesquisa
{
    public function __construct(protected StatusLeitura $model) {}

    public function listarStatusLeitura(): ?Collection
    {
        return $this->model->get();
    }
}
