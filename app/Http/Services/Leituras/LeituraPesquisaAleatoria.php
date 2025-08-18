<?php

namespace App\Http\Services\Leituras;

use App\Models\Leituras;

class LeituraPesquisaAleatoria
{
    public function __construct(protected Leituras $model) {}

    public function pesquisaLeituraAleatoria(): ?Leituras
    {
        return $this->model->inRandomOrder()->firstOrFail();
    }
}
