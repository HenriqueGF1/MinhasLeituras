<?php

namespace App\Http\Services\AvaliacaoLeitura;

use App\Models\AvaliacaoLeitura;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class AvaliacaoPesquisa
{
    public function __construct(protected AvaliacaoLeitura $model) {}

    public function pesquisa(): LengthAwarePaginator
    {
        return $this->model->with('leituras')->paginate();
    }
}
