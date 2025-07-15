<?php

namespace App\Http\Services\Leituras;

use App\Models\Leituras;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class LeiturasPesquisa
{
    public function __construct(protected Leituras $model) {}

    public function pesquisa(): LengthAwarePaginator
    {
        return $this->model->paginate();
    }
}
